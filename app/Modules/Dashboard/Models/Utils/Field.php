<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 17:17
 */

namespace App\Modules\Dashboard\Models\Utils;

use App\Modules\Dashboard\Models\ShakeModel;

class Field extends ShakeModel
{
    protected $fields = array(
        'parent_type' => array(
            'type' => 'not_editable',
            'title' => 'PARENT TYPE',
        ),
        'parent_id' => array(
            'type' => 'not_editable',
            'title' => 'PARENT ID',
        ),
        'file' => array(
            'type' => 'file',
            'title' => 'Файл',
        ),
        'text' => array(
            'type' => 'textarea',
            'title' => 'Текст',
        ),
        'field' => array(
            'type' => 'text',
            'title' => 'Поле',
        ),
        'is_file' => array(
            'type' => 'bool',
            'title' => 'Поле файловое?',
        ),
    );
    
    public function validate($data, $behavior = 'default') {
        
        $rules = array(
            //			'parent_type' => 'required',
            //			'parent_id' => 'required|integer',
            'text' => '',
            'is_file' => 'boolean',
            'file' => 'max:'.(1024*5),
            'field' => 'required|max:255',
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
    
    public function getFileName() {
        if (!empty($this->file)) {
            $tmp = explode('/', $this->file);
            return end($tmp);
        }
        
        return '';
    }
}
