<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Structure\Page;

class PagesController extends AdminController {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Page $page) {
        $this->model = $page;
    }
    
    public function def() {
        $items = $this->model->wherePageId(0)->orderBy('position')->get();
        return view('admin.pages.default', compact('items'));
    }
    
    public function position() {
        if (!request()->ajax()) {abort(404);}
        
        $this->validate(request(), [
            'id'        => 'required|integer',
            'parent_id' => 'required|integer',
            'before_id' => 'required|integer',
        ]);
        
        $obj = $this->model->find(request('id'));
        
        if ($obj) {
            $success = $obj->setParent(request('parent_id'), request('before_id'));
            if (!$success) {
                return response()->json(['error' => ['text' => 'Изменить объект не удалось']]);
            }
        }
        
        return response()->json(['data' => 1]);
    }
    
}
