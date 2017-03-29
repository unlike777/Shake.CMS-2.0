<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 21:32
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller {
    
    /**
     * @var $model \App\Models\ShakeModel;
     */
    protected $model;
    
    public function create() {
        $model = $this->model;
        
        if (!empty($_POST)) {
            $data = request()->all();
            $this->validateWith($model->validate($data));
            
            $model->fill($data);
            $model->save();
            
            return redirect()->route('admin.pages.edit', [$model->id]);
        }
        
        return view('admin.default.form', compact('model'));
    }
    
    public function edit($id) {
        $model = $this->model->findOrFail($id);

        if (!empty($_POST)) {
            $data = request()->all();
            $this->validateWith($model->validate($data));
            
            $model->fill($data);
            $model->save();
            
            return redirect()->back();
        }
        
        return view('admin.default.form', compact('model'));
    }
    
    public function delete($id = null) {
        if ($id) {
            $model = $this->model->findOrFail($id);
            $model->delete();
            return redirect()->back();
        }
        
        $models = $this->model->whereIn('id', request('objects'))->get();
        $models->map(function($item) {
            $item->delete();
        });
        return response()->json(['data' => 1]);
    }
    
    public function active() {
        if (!request()->ajax()) {
            abort(404);
        }
        
        $models = $this->model->whereIn('id', request('objects'))->get();
        foreach ($models as $model) {
            $model->active = !$model->active;
            $model->save();
        }
        
        return response()->json(['data' => 1]);
    }
    
}
