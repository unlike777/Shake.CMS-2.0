<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="https://github.com/unlike777/Shake.CMS-2.0" target="_blank">Shake.CMS 2.0</a>
    </div>
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li>
                <a href="/"><!--{Site_name} &mdash;--> перейти на сайт</a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i> Админ <span class="caret"></span>
                </a>

                {{--<ul class="dropdown-menu">--}}
                    {{--<li>--}}
                        {{--<a href="{{ route('usersEditAdmin', array('id' => Auth::id())) }}"><i class="glyphicon glyphicon-cog"></i> Профиль</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="/logout"><i class="glyphicon glyphicon-off"></i> Выйти</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            </li>
        </ul>
    </div>

</div>

<div class="sidebar">
    {{--@include('cms::widgets.mainMenu.default')--}}
</div>

<div class="content">
    <div class="content_inner">
        @yield('content')
    </div>
</div>


</body>
</html>
