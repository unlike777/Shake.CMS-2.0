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

}
