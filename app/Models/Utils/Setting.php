<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 17:17
 */

namespace App\Models\Utils;

use App\Models\ShakeModel;

class Setting extends ShakeModel
{
    protected $fields = array(
        'title' => array(
            'type' => 'text',
            'title' => 'Назначение',
        ),
        'alias' => array(
            'type' => 'text',
            'title' => 'Алиас (для быстрого вызова)',
        ),
        'text' => array(
            'type' => 'textarea',
            'title' => 'Текст',
        ),
    );
    
    public function validate($data, $behavior = 'default') {
        
        $rules = array(
            'title' => 'required|min:2',
            'alias' => 'required|alpha_dash|between:2,255|unique:settings,alias',
            'text' => '',
        );
        
        if (!empty($this->id)) {
            $rules['alias'] = $rules['alias'].','.$this->id;
        }
        
        return validator($data, $rules);
    }
    
    /**
     * Вернет значение или пустоту по алиасу
     * @param $alias
     * @return mixed
     */
    public static function getValue($alias) {
        return static::firstOrNew(array('alias' => $alias))->text;
    }
}
