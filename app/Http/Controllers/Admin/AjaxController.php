<?php

namespace App\Http\Controllers\Admin;

use App\Models\Utils\StickyFile;

class AjaxController {

    public function upload() {
        $file = app(StickyFile::class);
        $model = app(request('model'));
        
        $parent = $model->find(request('id'));
        $field = request('field');
        $input = request()->only(['file', 'field']);
        
        $validation = $file->validate($input);
        if ($parent && $validation->passes()) {
            $file->field = $field;
            $file->saveUploadFiles();
            if ($file->save()) {
                $parent->morphMany(StickyFile::class, 'parent')->save($file);
                $data = view('admin.widgets.stickyFiles._item', compact('file', 'field'))->render();
                return response(['error' => 0, 'data' => $data]);
            }
        }
        
        return response(['error' => 1, 'data' => 'Сохранить файл не удалось']);
    }

    public function delete() {
        
        /**
         * @var $file StickyFile
         */
        if ($id = request('id')) {
            if ($file = StickyFile::find($id)) {
                $file->log_on_delete();
                $file->delete();
            }
        }

        return response(['error' => 0]);
    }
    
}
