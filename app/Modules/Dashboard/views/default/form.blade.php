@extends('dashboard::layouts.default')

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
            
                <div class="col-md-9 form-horizontal">
    
                    @include('dashboard::widgets.form.default')
                    
                    @include('dashboard::widgets.form._submit')
    
                </div>

            {{ Form::close() }}
        </div>
        

    </div>
    
@endsection
