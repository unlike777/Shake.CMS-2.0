<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 17:17
 */

namespace App\Modules\Dashboard\Models\Utils;

use App\Modules\Dashboard\Models\ShakeModel;
use Symfony\Component\HttpFoundation\File\File;

class StickyFile extends ShakeModel
{
    protected $table = 'files';
    
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
        'field' => array(
            'type' => 'text',
            'title' => 'Поле',
        ),
        'sort' => array(
            'type' => 'text',
            'title' => 'Сортировка',
        ),
    );
    
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        
        $max_sort = static::whereParentId($this->parent_id)
            ->whereParentType($this->parent_type)
            ->whereField($this->field)
            ->max('sort');
        
        $this->sort = $max_sort + 1;
    }

    public function validate($data, $behavior = 'default') {
        
        $rules = array(
            //			'parent_type' => 'required',
            //			'parent_id' => 'required|integer',
            'file' => 'required|max:'.(1024*5),
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
    
    /**
     * Проверяет является ли файл изображением
     * @return bool
     */
    public function is_image() {
        
        $file_path = public_path($this->file);
        
        if (file_exists($file_path)) {
            $t = new File($file_path);
            $type = $t->getMimeType();
            $type = explode('/', $type);
            
            if ($type[0] == 'image') {
                return true;
            }
        }
        
        return false;
    }
}
