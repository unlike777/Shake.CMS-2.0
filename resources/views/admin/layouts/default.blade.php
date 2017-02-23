<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Shake.CMS</title>

    <link rel="SHORTCUT ICON" href="/cms/favicon.ico">

    <link type="text/css" rel="stylesheet" href="{{ uncache('admin/vendors/style.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ uncache('admin/app.css') }}">

    <script type="text/javascript" src="{{ uncache('admin/vendors/js.js') }}"></script>
    <script type="text/javascript" src="{{ uncache('admin/app.js') }}"></script>

</head>

<body>

@if (Session::has('message'))
    <div id="shake_message" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">{{ Session::get('message')['title'] }}</h4>
                </div>

                <div class="modal-body">{{ Session::get('message')['text'] }}</div>
            </div>
        </div>
    </div>
@endif

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="https://github.com/unlike777/Shake.CMS-2.0" target="_blank">Shake.CMS 2.0</a>

            <ul class="nav navbar-nav">
                <li>
                    <a href="/"><!--{Site_name} &mdash;--> перейти на сайт</a>
                </li>
            </ul>
        </div>
        <!-- Top Menu Items -->
        
        
        <ul class="nav navbar-right top-nav">
            
            
            {{--<li class="dropdown">--}}
                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>--}}
                {{--<ul class="dropdown-menu message-dropdown">--}}
                    {{--<li class="message-preview">--}}
                        {{--<a href="#">--}}
                            {{--<div class="media">--}}
                                    {{--<span class="pull-left">--}}
                                        {{--<img class="media-object" src="http://placehold.it/50x50" alt="">--}}
                                    {{--</span>--}}
                                {{--<div class="media-body">--}}
                                    {{--<h5 class="media-heading">--}}
                                        {{--<strong>John Smith</strong>--}}
                                    {{--</h5>--}}
                                    {{--<p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>--}}
                                    {{--<p>Lorem ipsum dolor sit amet, consectetur...</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="message-preview">--}}
                        {{--<a href="#">--}}
                            {{--<div class="media">--}}
                                    {{--<span class="pull-left">--}}
                                        {{--<img class="media-object" src="http://placehold.it/50x50" alt="">--}}
                                    {{--</span>--}}
                                {{--<div class="media-body">--}}
                                    {{--<h5 class="media-heading">--}}
                                        {{--<strong>John Smith</strong>--}}
                                    {{--</h5>--}}
                                    {{--<p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>--}}
                                    {{--<p>Lorem ipsum dolor sit amet, consectetur...</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="message-preview">--}}
                        {{--<a href="#">--}}
                            {{--<div class="media">--}}
                                    {{--<span class="pull-left">--}}
                                        {{--<img class="media-object" src="http://placehold.it/50x50" alt="">--}}
                                    {{--</span>--}}
                                {{--<div class="media-body">--}}
                                    {{--<h5 class="media-heading">--}}
                                        {{--<strong>John Smith</strong>--}}
                                    {{--</h5>--}}
                                    {{--<p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>--}}
                                    {{--<p>Lorem ipsum dolor sit amet, consectetur...</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="message-footer">--}}
                        {{--<a href="#">Read All New Messages</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="dropdown">--}}
                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>--}}
                {{--<ul class="dropdown-menu alert-dropdown">--}}
                    {{--<li>--}}
                        {{--<a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">View All</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
            
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a href="index.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a href="charts.html"><i class="fa fa-fw fa-bar-chart-o"></i> Charts</a>
                </li>
                <li>
                    <a href="tables.html"><i class="fa fa-fw fa-table"></i> Tables</a>
                </li>
                <li>
                    <a href="forms.html"><i class="fa fa-fw fa-edit"></i> Forms</a>
                </li>
                <li>
                    <a href="bootstrap-elements.html"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
                </li>
                <li>
                    <a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li>
                            <a href="#">Dropdown Item</a>
                        </li>
                        <li>
                            <a href="#">Dropdown Item</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Blank Page</a>
                </li>
                <li>
                    <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

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
