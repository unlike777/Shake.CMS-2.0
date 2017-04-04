@extends('admin.layouts.default')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header admin-h1">
                    Структура → Дерево сайта <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="{{ route('admin') }}">{{ config('admin.def_page_name') }}</a>
                    </li>
                    <li class="active">
                        Дерево сайта
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-default" href="{{ route('admin.pages.create') }}">Добавить страницу</a>
            </div>
        </div>

        <br>
        
        <div class="row">
            <div class="col-lg-7">

                <div class="dd tree" id="nestable3">
                    <ol class="dd-list">
                        @foreach($items as $item)
                            @include('admin.pages._one_line', compact('item'))
                        @endforeach
                    </ol>
                </div>
                
            </div>
        </div>

        <br>
        
        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-default" href="{{ route('admin.pages.create') }}">Добавить страницу</a>
            </div>
        </div>

    </div>
    
@endsection
