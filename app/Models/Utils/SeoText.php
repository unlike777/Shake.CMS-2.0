<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 17:17
 */

namespace App\Models\Utils;

use App\Models\ShakeModel;

class SeoText extends ShakeModel
{
    protected $fields = array(
        'title' => array(
            'type' => 'text',
            'title' => 'Заголовок',
        ),
        'keywords' => array(
            'type' => 'text',
            'title' => 'Ключевые слова',
        ),
        'description' => array(
            'type' => 'text',
            'title' => 'Мета описание',
        ),
    );
    
    public function validate($data, $behavior = 'default') {
        
        $rules = array(
            'title' => '',
        );
        
        return validator($data, $rules);
    }
    
    
    /**
     * Вернет родителя к которому прикреплен файл
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function parent() {
        return $this->morphTo();
    }
}
