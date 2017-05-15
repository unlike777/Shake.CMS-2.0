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
        $table_html = $this->table->html();

        $view = $this->module.'::admin.list';
        $view = view()->exists($view) ? $view : 'dashboard::default.list';
        
        return view($view, compact('table_html'));
    }
    
    public function create() {
        $model = $this->model;
        
        if (!empty($_POST)) {
            $data = request()->all();
            $this->validateWith($model->validate($data));
            
            $model->fill($data);
            $model->saveUploadFiles();
            $model->save();
            
            if (request('seo_block_enable')) {
                $seo = $model->seoText()->firstOrNew([]);
                $seo->fill([
                    'title' => request('seo_title'),
                    'keywords' => request('seo_keywords'),
                    'description' => request('seo_description'),
                ]);
                $model->seoText()->save($seo);
            }
            
            if (request('save_and_close')) {
                return redirect()->route('admin.'.$this->module.'.def');
            }
            
            return redirect()->route('admin.'.$this->module.'.edit', [$model->id])->with('message', 'Данные успешно сохранены!');
        }

        $view = $this->module.'::admin.form';
        $view = view()->exists($view) ? $view : 'dashboard::default.form';
        
        return view($view, compact('model'));
    }
    
    public function edit($id) {
        $model = $this->model->findOrFail($id);
        
        if (!empty($_POST)) {
            $data = request()->all();
            $this->validateWith($model->validate($data));
            
            $model->fill($data);
            $model->saveUploadFiles();
            $model->save();

            if (request('seo_block_enable')) {
                $seo = $model->seoText()->firstOrNew([]);
                $seo->fill([
                    'title' => request('seo_title'),
                    'keywords' => request('seo_keywords'),
                    'description' => request('seo_description'),
                ]);
                $model->seoText()->save($seo);
            }
            
            if (request('save_and_close')) {
                return redirect()->route('admin.'.$this->module.'.def');
            }
            
            return redirect()->back()->with('message', 'Данные успешно сохранены!');
        }

        $view = $this->module.'::admin.form';
        $view = view()->exists($view) ? $view : 'dashboard::default.form';
        
        return view($view, compact('model'));
    }
    
    public function delete($id = null) {
        if ($id) {
            $model = $this->model->findOrFail($id);
            $model->delete();
            $model->log_on_delete();
            return redirect()->back()->with('message', 'Данные успешно удалены!');
        }
        
        $models = $this->model->whereIn('id', request('objects'))->get();
        $models->map(function($item) {
            $item->delete();
            $item->log_on_delete();
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
