<?php

namespace App\Modules\Dashboard\Controllers\Admin;

use App\Modules\Dashboard\Models\Utils\StickyFile;

class AjaxController {

    public function upload() {
        $file = app(StickyFile::class);
        $model = app(request('model', false));
        
        $parent = $model->find(request('id'));
        $field = request('field');
        $input = request()->only(['file', 'field']);

        $max_sort = $parent->stickyFiles($field)->max('sort');
        
        $validation = $file->validate($input);
        if ($parent && $validation->passes()) {
            $file->field = $field;
            $file->sort = ++$max_sort;
            $file->saveUploadFiles();
            if ($file->save()) {
                $parent->morphMany(StickyFile::class, 'parent')->save($file);
                $data = view('dashboard::widgets.stickyFiles._item', compact('file', 'field'))->render();
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
                $parent = $file->parent;
                $field_type = $file->field;
                
                $file->log_on_delete();
                $file->delete();
                
                $sfiles = $parent->stickyFiles($field_type)->orderBy('sort')->get();
                foreach ($sfiles as $num => $sfile) {
                    $sfile->update(['sort' => ++$num]);
                }
            }
        }

        return response(['error' => 0]);
    }
    
    public function move() {
        $item = StickyFile::findOrFail(request('item_id'));
        $left_item = StickyFile::find(request('left_item_id'));
        
        $parent = $item->parent;
        $field_type = $item->field;

        if ($left_item) {
            $sfiles = $parent->stickyFiles($field_type)->orderBy('sort')->where('sort', '>', $left_item->sort)->get();
            foreach ($sfiles as $num => $sfile) {
                $sfile->update(['sort' => ++$sfile->sort]);
            }
            $item->update(['sort' => ++$left_item->sort]);
        } else {
            $sfiles = $parent->stickyFiles($field_type)->orderBy('sort')->get();
            foreach ($sfiles as $num => $sfile) {
                $sfile->update(['sort' => $num + 2]);
            }
            $item->update(['sort' => 1]); 
        }

        $sfiles = $parent->stickyFiles($field_type)->orderBy('sort')->get();
        foreach ($sfiles as $num => $sfile) {
            $sfile->update(['sort' => ++$num]);
        }
        
        return response([]);
    }
}
