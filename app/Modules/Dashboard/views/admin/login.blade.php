<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Admin Login</title>

    <link rel="SHORTCUT ICON" href="/admin/favicon.ico">

    <link type="text/css" rel="stylesheet" href="{{ uncache('assets/admin/vendor/vendor.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ uncache('assets/admin/app.css') }}">

    <script type="text/javascript" src="{{ uncache('assets/admin/vendor/vendor.js') }}"></script>
    <script type="text/javascript" src="{{ uncache('assets/admin/app.js') }}"></script>

</head>

<body style="background: #222;">

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-push-3">
            <div class="panel panel-default">
                <div class="panel-heading">Вход в панель управления</div>
                <div class="panel-body">
                    {{ Form::open(array('class' => 'form-horizontal', 'role' => 'form')) }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">Эл. почта</label>

                        <div class="col-md-6">
                            {{ Form::email('email', null, ['id' => 'email', 'class' => 'form-control']) }}

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Пароль</label>

                        <div class="col-md-6">
                            {{ Form::password('password', ['id' => 'password', 'class' => 'form-control']) }}
                            
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('remember') }} Запомнить меня
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    @if ($errors->has('errors'))
                        <div class="form-group has-error">
                            <label class="col-md-4 control-label">&nbsp;</label>

                            <div class="col-md-6">
                                <span class="help-block">
                                    <strong>{{ $errors->first('errors') }}</strong>
                                </span>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i> Войти
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>
