@extends('admin.layouts.default')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header admin-h1">
                    Информация о сервере <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="{{ route('admin') }}">{{ config('admin.def_page_name') }}</a>
                    </li>
                    <li class="active">
                        Информация о сервере
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <style>
                    iframe{border: 0; width: 100%; height: 750px; min-width: 940px;}
                </style>

                <iframe id="iframe" src="{{ route('admin.info.php') }}" scrolling="no"></iframe>

                <script>
                    $('#iframe').on('load', function() {
                        var $iframe = $(this);
                        var $iframe_body = $iframe.contents().find('body');
                        $iframe.height($iframe_body[0].scrollHeight);
                    });
                </script>
            </div>
        </div>

    </div>
    
@endsection
