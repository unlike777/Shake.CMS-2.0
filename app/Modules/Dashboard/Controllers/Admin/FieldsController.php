<?php

namespace App\Modules\Dashboard\Controllers\Admin;

use App\Modules\Dashboard\Models\Utils\Field;
use App\Modules\Dashboard\Models\ShakeModel;

class FieldsController {
    
    public function	create($parent_id) {
        $field = new Field();
        
        /**
         * @var $parent ShakeModel
         */
        $parent = app(request('model'))->find($parent_id);
        
        if (!$parent) {
            return response(['error' => 1, 'data' => 'Родитель не найден']);
        }
        
        $data = request()->all();
        $validation = $field->validate($data);
        
        if ($validation->fails()) {
            return response(['error' => 1, 'data' => $validation->errors()->first()]);
        }
        
        $field->fill($data);
        
        if ($field->save()) {
            $parent->uniqueFields()->save($field);
            $view = view('dashboard::widgets.fields.default', ['model' => $parent, 'field_id' => $field->id])->render();
            return response(['error' => 0, 'data' => $view]);
        }
        
        return response(['error' => 1, 'data' => 'Сохранить файл не удалось']);
    }
    
    public function	update($id) {
        /**
         * @var $field Field
         */
        $field = Field::find($id);

        if (!$field) {
            return response(['error' => 1, 'data' => 'Поле не найдено!']);
        }
        
        $data = request()->all();
        $validation = $field->validate($data);
        
        if ($validation->fails()) {
            return response(['error' => 1, 'data' => $validation->errors()->first()]);
        }
        
        $field->fill($data);
        
        if ($field->save()) {
            $view = view('dashboard::widgets.fields.default', ['model' => $field->parent, 'field_id' => $field->id])->render();
            return response(['error' => 0, 'data' => $view]);
        }
        
        return response(['error' => 1, 'data' => 'Сохранить файл не удалось']);
    }
    
    public function	delete($id) {
        /**
         * @var $field Field
         */
        $field = Field::find($id);
        
        if (!$field) {
            return response(['error' => 1, 'data' => 'Поле не найдено!']);
        }
        
        $field->log_on_delete();
        $field->delete();
        
        $view = view('dashboard::widgets.fields.default', ['model' => $field->parent])->render();
        return response(['error' => 0, 'data' => $view]);
    }
    
}
