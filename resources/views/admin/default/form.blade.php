@extends('admin.layouts.default')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header admin-h1">
                    Форма <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="{{ route('admin') }}">{{ config('admin.def_page_name') }}</a>
                    </li>
                    <li class="active">
                        Форма
                    </li>
                </ol>
            </div>
        </div>

        <div class="form-wr" style="display: none;">

            <div class="panel panel-default">
                {{ Form::open(['class' => 'form-horizontal']) }}
                <div class="panel-body">

                    <div class="form-group">
                        <div class="col-md-offset-5 col-md-7">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Активность
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-md-5 control-label">Заголовок</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-md-5 control-label">Минитекст</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="inputPassword3" placeholder="">
                        </div>
                    </div>



                    <div class="form-group">
                        <label style="text-align: center;" class="col-md-12">
                            <div style="background: #efefef; padding: 3px 0;">Содержание</div>
                        </label>
                        <div class="col-md-12">
                            <textarea class="form-control" style="min-height: 150px;"></textarea>
                        </div>
                    </div>

                    {{--<div class="form-group">--}}
                        {{--<div class="col-md-offset-5 col-md-7">--}}
                            {{--<button type="submit" class="btn btn-default">Сохранить</button>--}}
                            {{--&nbsp;&nbsp;--}}
                            {{--<button type="submit" class="btn btn-default">Применить</button>--}}
                            {{--&nbsp;&nbsp;&nbsp;--}}
                            {{--или--}}
                            {{--&nbsp;&nbsp;&nbsp;--}}
                            {{--<a href="">Вернуться назад</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    
                </div>
                <div class="panel-footer" style="text-align: center;">
                    <button type="submit" class="btn btn-default">Сохранить</button>
                    &nbsp;&nbsp;
                    <button type="submit" class="btn btn-default">Применить</button>
                    &nbsp;&nbsp;&nbsp;
                    или
                    &nbsp;&nbsp;&nbsp;
                    <a href="">Вернуться назад</a>
                </div>
                {{ Form::close() }}
            </div>
            
            
        </div>
        
        
        
        <div class="row">
            <div class="col-md-9">
 
                {{ Form::model($model, ['class' => 'form-horizontal']) }}

                @include('admin.widgets.form.default', compact('model'))

                <div class="form-group">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn btn-default">Сохранить</button>
                        &nbsp;&nbsp;
                        <button type="submit" class="btn btn-default">Применить</button>
                        &nbsp;&nbsp;&nbsp;
                        или
                        &nbsp;&nbsp;&nbsp;
                        <a href="">Вернуться назад</a>
                    </div>
                </div>



                {{ Form::close() }}
            </div>
        </div>
        

    </div>
    
@endsection
