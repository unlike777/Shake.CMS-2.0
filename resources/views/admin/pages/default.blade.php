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

                <div class="dd" id="nestable3">
                    <ol class="dd-list">
                        <li class="dd-item dd3-item" data-id="13">
                            <div class="dd-handle dd3-handle">Drag</div>
                            <div class="dd3-content">
                                <i class="glyphicon glyphicon-eye-open eye_btn"></i>
                                <a href="">Item 13</a>
                                <div class="dd-right">
                                    <a href="" class="glyphicon glyphicon-pencil"></a>
                                    <a href="" class="glyphicon glyphicon-share" target="_blank"></a>
                                    <a href="" class="glyphicon glyphicon-trash table__row_delete"></a>
                                </div>
                            </div>
                        </li>
                        <li class="dd-item dd3-item" data-id="14">
                            <div class="dd-handle dd3-handle">Drag</div>
                            <div class="dd3-content">
                                <i class="glyphicon glyphicon-eye-open eye_btn"></i>
                                <a href="">Item 14</a>
                                <div class="dd-right">
                                    <a href="" class="glyphicon glyphicon-pencil"></a>
                                    <a href="" class="glyphicon glyphicon-share" target="_blank"></a>
                                    <a href="" class="glyphicon glyphicon-trash table__row_delete"></a>
                                </div>
                            </div>
                        </li>
                        <li class="dd-item dd3-item" data-id="15">
                            <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">Item 15</div>
                            <ol class="dd-list">
                                <li class="dd-item dd3-item" data-id="16">
                                    <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">Item 16</div>
                                </li>
                                <li class="dd-item dd3-item" data-id="17">
                                    <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">Item 17</div>
                                </li>
                                <li class="dd-item dd3-item" data-id="18">
                                    <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">Item 18</div>
                                </li>
                            </ol>
                        </li>
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
