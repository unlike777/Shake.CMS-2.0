<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 17:17
 */

namespace App\Models\Utils;

use App\Models\ShakeModel;

class Reg extends ShakeModel
{
    protected $fields = array(
        'key' => array(
            'type' => 'text',
            'title' => 'Ключ',
        ),
        'value' => array(
            'type' => 'text',
            'title' => 'Значение',
        ),
    );
    
    public function validate($data, $behavior = 'default') {
    
        $rules = array(
            'key' => 'required|min:2|unique:regs,key',
            'value' => '',
        );
    
        if (!empty($this->id)) {
            $rules['key'] = $rules['key'].','.$this->id;
        }
    
        return validator($data, $rules);
    }
    
    /**
     * Устанавливает значение по ключу, возвращает переданное значение
     * @param $alias
     * @param $value
     * @return mixed
     */
    public static function set($key, $value) {
        $obj = static::where('key', '=', $key)->first();
        if (!$obj) {
            $obj = new static();
        }
        
//        $data = $obj->prepareData(array('key' => $key, 'value' => $value));
        $data = ['key' => $key, 'value' => $value];
        $validation = $obj->validate($data);
        
        if ($validation->passes()) {
            $obj->fill($data);
            $obj->save();
        }
        
        return $value;
    }
    
    /**
     * Вернет значение по ключю
     * @param array $key
     * @param null $defValue
     * @return mixed|null
     */
    public static function get($key, $defValue = NULL) {
        $obj = static::where('key', '=', $key)->first();
        if ($obj) {
            return $obj->value;
        }
        
        return $defValue;
    }
    
    /**
     * Удалит значение с заданным ключом
     * @param $key
     */
    public static function del($key) {
        static::where('key', '=', $key)->delete();
    }
}
