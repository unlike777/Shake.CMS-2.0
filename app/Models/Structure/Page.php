<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 17:17
 */

namespace App\Models\Structure;

use App\Models\ShakeModel;

class Page extends ShakeModel
{
    protected $attributes = array(
        'page_id' => 0,
        'active' => 1,
    );
    
    protected $fields = array(
        'title' => array(
            'type' => 'text',
            'title' => 'Заголовок страницы',
        ),
        'slug' => array(
            'type' => 'text',
            'title' => 'Псевдо адрес',
        ),
        'active' => array(
            'type' => 'bool',
            'title' => 'Активность',
        ),
        'is_home' => array(
            'type' => 'bool',
            'title' => 'Домашняя?',
        ),
        'template' => array(
            'type' => 'select',
            'title' => 'Шаблон страницы',
            'values' => array(
                'default' => 'Стандартный',
                'home'    => 'Домашний',
                'second'  => 'Второстепенный',
            ),
        ),
        'content' => array(
            'type' => 'ckeditor',
            'title' => 'Содержание',
        ),
        'link' => array(
            'type' => 'text',
            'title' => 'Ссылка',
        ),
        'file' => array(
            'type' => 'file',
            'title' => 'Файл',
        ),
    );
    
    protected $ajax_files = array(
        'images' => 'Картинки',
        'test' => 'Тест',
    );
    
    
    public function save(array $options = array()) {
        
        if ($this->is_home == 1) {
            $data = Page::where('is_home', '=', 1);
            
            if (!empty($this->id)) {
                $data->where('id', '<>', $this->id);
            }
            
            foreach ($data->get() as $item) {
                $item->is_home = 0;
                $item->save();
            }
        }
        
        return parent::save($options);
    }
    
    public static function boot() {
        parent::boot();
        
        static::creating(function($obj) {
            $pos = self::max('position') + 1;
            $obj->position = $pos;
        });
    }
    
    /**
     * @param $data
     * @param $behavior
     * @return \Illuminate\Validation\Validator
     */
    public function validate($data, $behavior = 'default') {
        $rules = array(
            'title' => 'required|min:2',
            'slug' => 'required|alpha_dash|between:2,255|unique:pages,slug',
            'content' => '',
            'active' => 'boolean',
            'is_home' => 'boolean',
            'template' => 'required',
            'file' => 'max:'.(1024*5),
        );
        
        if (!empty($this->id)) {
            $rules['slug'] = $rules['slug'].','.$this->id;
        }
        
        return validator($data, $rules);
    }
    
    
    public function url() {
        
        if ($this->is_home) {
            return '/';
        }
        
        if (trim($this->link)) {
            return $this->link;
        }
        
        return '/pages/'.$this->slug;
    }
    
    public function pages() {
        return $this->hasMany(Page::class);
    }
    
}
