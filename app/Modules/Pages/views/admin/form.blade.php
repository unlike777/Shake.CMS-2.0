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

            {{ Form::model($model, ['files' => true]) }}

                @include('admin.widgets.seoText.default')
            
                <div class="col-md-9 form-horizontal">
    
                    @include('admin.widgets.form.default')
                    
                    @include('admin.widgets.form._submit')

                    
                    
                </div>
            
            {{ Form::close() }}
            
            <div class="col-md-9">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    @include('admin.widgets.stickyFiles.default', compact('model'))
                </div>

                <div class="col-md-3"></div>
                <div class="col-md-9">
                    @include('admin.widgets.fields.default', compact('model'))
                </div>
            </div>
            
        </div>
        

    </div>
    
@endsection
