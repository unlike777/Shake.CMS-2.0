<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Shake.CMS</title>

    <link rel="SHORTCUT ICON" href="/assets/admin/favicon.ico">

    <link type="text/css" rel="stylesheet" href="{{ uncache('assets/admin/vendor/vendor.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ uncache('assets/admin/app.css') }}">

    <script type="text/javascript" src="{{ uncache('assets/admin/vendor/vendor.js') }}"></script>
    <script type="text/javascript" src="{{ uncache('assets/admin/app.js') }}"></script>
    
    <script type="text/javascript" src="{{ uncache('assets/admin/ckeditor/ckeditor.js') }}"></script>

</head>

<body>

@if ($errors->count())
    <div id="shake_message" class="modal fade in" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" style="font-weight: bold;">Ошибка!</h4>
                </div>

                <div class="modal-body text-danger">
                    @if($errors->count() > 1)
                        <ul style="margin-bottom: 0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $errors->first() }}
                    @endif
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
@endif

<div id="wrapper">

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="https://github.com/unlike777/Shake.CMS-2.0" target="_blank">Shake.CMS 2.0</a>
        </div>

        <div class="collapse navbar-collapse navbar-left">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/"><!--{Site_name} &mdash;--> перейти на сайт</a>
                </li>
            </ul>
        </div>
        
        <ul class="nav navbar-right top-nav">
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('admin.users.edit', [Auth::id()]) }}"><i class="fa fa-fw fa-gear"></i> Профиль</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('admin.logout') }}"><i class="fa fa-fw fa-power-off"></i> Выйти</a>
                    </li>
                </ul>
            </li>
            
        </ul>
        
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        @include('dashboard::widgets.menu.main')
        <!-- /.navbar-collapse -->
        
    </nav>

    <div id="page-wrapper">

        @if (session('message'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        @endif
        
        @yield('content')

    </div>

</div>

</body>

</html>
















{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
    {{--<meta charset="UTF-8">--}}
    {{--<title>Shake.CMS</title>--}}

    {{--<link rel="SHORTCUT ICON" href="/cms/favicon.ico">--}}
    {{----}}
    {{--<link type="text/css" rel="stylesheet" href="{{ uncache('admin/vendors/style.css') }}">--}}
    {{--<link type="text/css" rel="stylesheet" href="{{ uncache('admin/app.css') }}">--}}
    {{----}}
    {{--<script type="text/javascript" src="{{ uncache('admin/vendors/js.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ uncache('admin/app.js') }}"></script>--}}
{{--</head>--}}
{{--<body>--}}

{{--@if (Session::has('message'))--}}
    {{--<div id="shake_message" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="false">--}}
        {{--<div class="modal-dialog modal-sm">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
                    {{--<h4 class="modal-title" id="mySmallModalLabel">{{ Session::get('message')['title'] }}</h4>--}}
                {{--</div>--}}

                {{--<div class="modal-body">{{ Session::get('message')['text'] }}</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endif--}}


{{--<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">--}}
    {{--<div class="container-fluid">--}}
        {{--<div class="navbar-header">--}}
            {{--<a class="navbar-brand" href="https://github.com/unlike777/Shake.CMS-2.0" target="_blank">Shake.CMS 2.0</a>--}}
        {{--</div>--}}
        {{--<div class="navbar-collapse collapse">--}}
            {{--<ul class="nav navbar-nav">--}}
                {{--<li>--}}
                    {{--<a href="/"><!--{Site_name} &mdash;--> перейти на сайт</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
    {{----}}
            {{--<ul class="nav navbar-nav navbar-right">--}}
                {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                        {{--<i class="glyphicon glyphicon-user"></i> Админ <span class="caret"></span>--}}
                    {{--</a>--}}
    {{----}}
                    {{--<ul class="dropdown-menu">--}}
                    {{--<li>--}}
                    {{--<a href="{{ route('usersEditAdmin', array('id' => Auth::id())) }}"><i class="glyphicon glyphicon-cog"></i> Профиль</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                    {{--<a href="/logout"><i class="glyphicon glyphicon-off"></i> Выйти</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}


    {{----}}




{{--<div class="sidebar">--}}
    {{--@include('cms::widgets.mainMenu.default')--}}
{{--</div>--}}

{{--<div class="content">--}}
    {{--<div class="content_inner">--}}
{{--        @yield('content')--}}
    {{--</div>--}}
{{--</div>--}}


{{--</body>--}}
{{--</html>--}}
