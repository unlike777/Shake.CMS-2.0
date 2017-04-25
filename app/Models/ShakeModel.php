<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 17:08
 */

namespace App\Models;

use App\Models\Utils\SeoText;
use App\Modules\Pages\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Schema;
use Storage;

class ShakeModel extends \Eloquent {
    
    protected $fields = [];
    protected $guarded = []; //all access
    
    /**
     * избегаем множественной генерации запросов для получения списка колонок модели
     * массив, потому что для каждого отдельного класса список полей разный
     * @var array
     */
    static protected $columns = []; 
    
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seoText() {
        return $this->morphOne(SeoText::class, 'parent');
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

                $destination = 'upload/'.$type.'/'.date('Y_m').'/';
                
                $i = 0;
                while (Storage::exists($destination.$new_name)) {
                    $i++;
                    $new_name = $name.'_'.$i.'.'.$ext;
                }
                
                $path = $file->storeAs($destination, $new_name);
                
                $this->{$key} = '/'.$path;
            } else {
                if (request()->has($key.'_del')) {
                    $this->{$key} = '';
                }
            }
        }
    }

}
