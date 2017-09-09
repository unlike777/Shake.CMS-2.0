<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 17:08
 */

namespace App\Modules\Dashboard\Models;

use App\Modules\Dashboard\Models\Utils\Field;
use App\Modules\Dashboard\Models\Utils\SeoText;
use App\Modules\Dashboard\Models\Utils\StickyFile;
use App\Modules\Pages\Models\Page;
use App\Shake\Libs\Logger;
use Illuminate\Database\Eloquent\Model;
use Schema;
use Storage;
use Resizer;

class ShakeModel extends \Eloquent {
    
    protected $fields = [];
    protected $guarded = []; //all access
    
    public $enableSEO = false;
    public $enableSticky = false;
    public $enableUFields = false;
    
    /**
     * избегаем множественной генерации запросов для получения списка колонок модели
     * массив, потому что для каждого отдельного класса список полей разный
     * @var array
     */
    static protected $columns = [];

    public function __construct(array $attributes = []) {

        //для поля сортировки
        $fields = $this->getFillable();
        if (in_array('sort', $fields)) {
            $this->sort = static::max('sort') + 10;
        }

        parent::__construct($attributes);
    }
    
    /**
     * Вернет все поля формирующие форму редактирования
     * @return array
     */
    public function getFormFields() {
        return $this->fields;
    }
    
    /**
     * @param $data
     * @param string $behavior
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data, $behavior = 'default') {
        return validator($data);
    }

    /**
     * Вернет список ajax'овых файловых заргузчиков
     * @return array
     */
    public function getAjaxFields() {
        return $this->ajax_files || [];
    }
    
    /**
     * Вернет все поля по которым можно фильтровать в общем списке
     * @return array
     */
    public function getFilterFields() {
        $tmp = array();
        foreach ($this->fields as $key => $item) {
            if ( isset($item['filter']) && ($item['filter'] == 1) ) {
                $item['value'] = NULL;
                $tmp['filter['.$key.']'] = $item;
            }
        }
        return $tmp;
    }

    /**
     * Проверяет есть ли у класса поле active (нужно для талицы в админке)
     * @return bool
     */
    public function hasActive() {
        return in_array('active', $this->getFillable()) ? true : false;
    }

    /**
     * При массовом присваивании отсеиваем все поля, которых не существует в таблице
     * для каждого класса набор полей свой
     * @return array
     */
    public function getFillable() {
        if (empty(static::$columns[static::class])) {
            static::$columns[static::class] = Schema::getColumnListing($this->getTable());
        }
        
        return static::$columns[static::class];
    }

    /**
     * Вернет все файловые поля
     * @return array
     */
    public function getFileFields() {
        $tmp = array();
        foreach ($this->fields as $key => $item) {
            if (isset($item['type']) && ($item['type'] == 'file')) {
                $tmp[] = $key;
            }
        }
        return $tmp;
    }

    /**
     * Возвратит все приклепленные файлы к объекту
     * @param null $field - доп. фильтр по типу поля
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function stickyFiles($field = NULL) {
        $query = $this->morphMany(StickyFile::class, 'parent');

        if ($field) {
            $query->where('field', '=', $field);
        }
        
        return $query;
    }

    /**
     * Возвратит сео текст для данного объекта
     * @return array|\Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function uniqueFields() {
        return $this->MorphMany(Field::class, 'parent');
    }

    /**
     * Получение текста уникального поля
     * @param $alias
     * @return string
     */
    public function uField($alias) {
        $uField = $this->uniqueFields()->whereField($alias)->first();
        if ($uField) {
            return $uField->text;
        }
        return '';
    }

    /**
     * Возвратит сео текст для данного объекта
     * @return array|\Illuminate\Database\Eloquent\Relations\morphOne
     */
    public function seoText() {
        return $this->morphOne(SeoText::class, 'parent');
    }
    
    public function delete() {
        
        $this->seoText()->delete();
        
        foreach ($this->stickyFiles()->get() as $file) {
            $file->delete();
        }
        
        foreach ($this->uniqueFields()->get() as $field) {
            $field->delete();
        }
        
        foreach ($this->getFileFields() as $key) {
            Resizer::image($this->{$key})->deleteCache();
            @unlink(public_path().$this->{$key});
        }
        
        return parent::delete();
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = array()) {
        
        foreach ($this->getFileFields() as $key) {
            
            $origin = $this->getOriginal($key);
            if (!empty($origin)) {
                if ($this->{$key} != $origin) {
                    Resizer::image($origin)->deleteCache();
                    @unlink(public_path().$origin);
                }
            }
            
        }
        
        return parent::save($options);
    }
    
    /**
     * Проверяет и сохраняет файлы пришедшие через POST
     * @param $input
     */
    public function saveUploadFiles() {
        foreach ($this->getFileFields() as $key) {
            
            if (request()->hasFile($key)) {
                $file = request()->file($key);

                $ext = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $name = str_replace('.'.$ext, '', $name);
                $name = str_slug($name, '_');
                
                $type = $file->getMimeType();
                $type = explode('/', $type);

                $type = ($type[0] == 'image') ? 'images' : 'files';

                $new_name = $name.'.'.$ext;
                
                $destination = 'upload/'.$type.'/'.date('Y_m');
                
                $i = 0;
                while (Storage::exists($destination.'/'.$new_name)) {
                    $i++;
                    $new_name = $name.'_'.$i.'.'.$ext;
                }
                
                $path = $file->storeAs($destination, $new_name);
                
                if ($type == 'images') {
                    Resizer::image('/'.$path)->preResize();
                }
                
                $this->{$key} = '/'.$path;
            } else {
                if (request()->has($key.'_del')) {
                    $this->{$key} = '';
                }
            }
        }
    }

    /**
     * Записывает информацию в лог при удалении объекта
     * @return $this
     */
    public function log_on_delete() {
        
        $log = new Logger('deletes/delete.log');
        
        $obj_info = ['model' => class_basename($this)];
        foreach (['id', 'title', 'email', 'file', 'field'] as $field) {
            $obj_info[$field] = $this->{$field};
        }
        
        $str = date('[Y-m-d H:i:s]').'   '
            .fit_line('['.request()->getClientIp().']', 19).' '
            .fit_line('['.user_field('email').']', 25)
            .json_encode($obj_info, JSON_UNESCAPED_UNICODE);
        
        $log->add($str)->save();
        
        return $this;
    }
    
    public function scopePubl($query) {
        $user = auth()->user();
        $is_admin_mode = request('admin_mode') && $user && $user->isAdmin();
        if (!$is_admin_mode) {
            $query->whereActive(true);
        }
    }

}
