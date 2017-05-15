<?php

namespace App\Modules\Pages\Models;

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
        
        static::deleting(function($obj) {
            $obj->pages->map(function($item) {
                $item->delete();
            });
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
            return url('/');
        }
        
        if (trim($this->link)) {
            return url($this->link);
        }
        
        return route('pages', [$this->slug]);
    }
    
    public function pages() {
        return $this->hasMany(Page::class);
    }
    
    /**
     * Информация о страницы для дерева в админке
     * @return array
     */
    public function info() {
        $info = [];
        
        if ($this->is_home) {
            $info[] = 'домашняя';
        }
    
        if (trim($this->link)) {
            $info[] = 'ссылка: '.$this->link;
        }
        
        return $info;
    }
    
    
    public function setParent($parent_id = 0, $before_id = false) {
        $parent = static::find($parent_id);
        if ( ($parent_id != 0) && !$parent) {return false;}
        
        $this->page_id = $parent_id;

        $new_pos = 0;
        
        if ($before_id !== false) {
            if ($before_id == 0) {
                //вставляем в начало
                $new_pos = 0;
                static::where('id', '!=', $this->id)->where('page_id', '=', $parent_id)->increment('position');
            } else {
                //вставляем после конкретного элемента
                $before_obj = static::find($before_id);
                if ($before_obj) {
                    $new_pos = $before_obj->position;
                    static::where('id', '!=', $this->id)->wherePageId($parent_id)->where('position', '>', $new_pos)->increment('position');
                    $new_pos++;
                }
            }
        } else {
            //вставляем в самый конец
            $new_pos = static::where('id', '!=', $this->id)->where('page_id', '=', $parent_id)->max('position');
            $new_pos++;
        }
        
        $this->position = $new_pos;
        $this->save();
        
        return true;
    }
    
}
