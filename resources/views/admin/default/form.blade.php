@extends('admin.layouts.default')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header admin-h1">
                    {{ $module_name }} <small>{{ $model->exists ? 'Редактирование' : 'Создание'  }} {{ $decls['form'] }}</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="{{ route('admin') }}">{{ config('admin.def_page_name') }}</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('admin.'.$module.'.def') }}">{{ $module_name }}</a>
                    </li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-9">
 
                {{ Form::model($model, ['class' => 'form-horizontal']) }}

                @include('admin.widgets.form.default', compact('model'))
                
                @include('admin.widgets.form._submit')

                {{ Form::close() }}
            </div>
        </div>
        

    </div>
    
@endsection
