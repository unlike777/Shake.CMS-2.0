<?php

namespace App\Modules\Settings\Models;

use App\Modules\Dashboard\Models\ShakeModel;

class Setting extends ShakeModel
{
    protected $fields = [
        'title' => [
            'type' => 'text',
            'title' => 'Назначение',
            'filter' => true,
        ],
        'alias' => [
            'type' => 'text',
            'title' => 'Алиас (для быстрого вызова)',
        ],
        'text' => [
            'type' => 'textarea',
            'title' => 'Текст',
        ],
    ];
    
    public function validate($data, $behavior = 'default') {
        
        $rules = [
            'title' => 'required|min:2',
            'alias' => 'required|alpha_dash|between:2,255|unique:settings,alias',
            'text' => '',
        ];
        
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
        return static::firstOrNew(['alias' => $alias])->text;
    }
}
