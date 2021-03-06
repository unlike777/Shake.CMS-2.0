@extends('dashboard::layouts.default')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header admin-h1">
                    {{ $module_name }} → Список {{ $decls['list'] }} <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="{{ route('admin') }}">{{ config('admin.def_page_name') }}</a>
                    </li>
                    <li class="active">
                        {{ $module_name }}
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-default" href="{{ route('admin.'.$module.'.create') }}">Создать</a>
            </div>
        </div>

        <br>
        
        <div class="row">
            <div class="col-lg-12">

                {!! $table_html !!}
                
            </div>
        </div>

        <br>
        
        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-default" href="{{ route('admin.'.$module.'.create') }}">Создать</a>
            </div>
        </div>

    </div>
    
@endsection
