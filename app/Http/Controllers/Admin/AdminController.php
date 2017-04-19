<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 21:32
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shake\Libs\ShakeTable;

class AdminController extends Controller {
    
    /**
     * @var $model \App\Models\ShakeModel;
     */
    protected $model;

    /**
     * @var $table \App\Shake\Libs\ShakeTable;
     */
    protected $table;

    //название модуля на транслите
    protected $module; 
    
    public function __construct() {
        $this->table = new ShakeTable();
        $this->table->setModel($this->model);
        $this->table->setModule($this->module);
        
        view()->share('module', $this->module);
    }

    public function def() {
        return view('admin.default.list', ['table' => $this->table]);
    }
    
    public function create() {
        $model = $this->model;
        
        if (!empty($_POST)) {
            $data = request()->all();
            $this->validateWith($model->validate($data));
            
            $model->fill($data);
            $model->save();

            if (request('save_and_close')) {
                return redirect()->route('admin.'.$this->module.'.def');
            }
            
            return redirect()->route('admin.'.$this->module.'.edit', [$model->id])->with('message', 'Данные успешно сохранены!');
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
            
            if (request('save_and_close')) {
                return redirect()->route('admin.'.$this->module.'.def');
            }
            
            return redirect()->back()->with('message', 'Данные успешно сохранены!');
        }
        
        return view('admin.default.form', compact('model'));
    }
    
    public function delete($id = null) {
        if ($id) {
            $model = $this->model->findOrFail($id);
            $model->delete();
            return redirect()->back()->with('message', 'Данные успешно удалены!');
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
