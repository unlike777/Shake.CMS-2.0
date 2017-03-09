<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 21:32
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    
    /**
     * @var $model \App\Models\ShakeModel;
     */
    protected $model;
    
    public function create()
    {   
        $model = $this->model;
        
        if (!empty($_POST))
        {
            $data = request()->all();
            $this->validateWith($model->validate($data));
            
            $model->fill($data);
            $model->save();
            
            return redirect()->route('admin.pages.edit', [$model->id]);
        }
        
        return view('admin.default.form', compact('model'));
    }
    
    public function edit($id)
    {
        $model = $this->model->findOrFail($id);
    
        if (!empty($_POST))
        {
            $data = request()->all();
            $this->validateWith($model->validate($data));
            die;
            $model->fill($data);
            $model->save();
        
            return redirect()->back();
        }
        
        return view('admin.default.form', compact('model'));
    }
    
}
