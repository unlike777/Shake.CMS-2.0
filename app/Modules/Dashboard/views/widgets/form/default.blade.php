@foreach($model->getFormFields() as $fname => $field)

    @if ($field['type'] == 'text')

        <div class="form-group">
            <label class="col-md-3 control-label">{{ $field['title'] }}</label>
            <div class="col-md-9">
                {{ Form::text($fname, null, array('class' => 'form-control')) }}
                @include('dashboard::widgets.form._help', compact('field'))
            </div>
        </div>

    @elseif ($field['type'] == 'not_editable')

        <div class="form-group">
            <label class="col-md-3 control-label">{{ $field['title'] }}</label>
            <div class="col-md-9">
                {{ Form::text($fname, null, array('class' => 'form-control', 'disabled' => 'disabled')) }}
                @include('dashboard::widgets.form._help', compact('field'))
            </div>
        </div>

    @elseif ($field['type'] == 'date')

        @php ($format = isset($field['format']) ? $field['format'] : 'Y-m-d H:i:S')

        <div class="form-group">
            <label class="col-md-3 control-label">{{ $field['title'] }}</label>
            <div class="col-md-9">
                <div class='input-group date' id='datetimepicker_{{ $fname }}'>
                    {{ Form::text($fname, null, array('class' => 'form-control')) }}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                @include('dashboard::widgets.form._help', compact('field'))
            </div>

            <script type="text/javascript">
                $(document).ready(function() {
                    flatpickr('#datetimepicker_{{ $fname }} input', {
                        dateFormat: '{{ $format }}',
                        locale: 'ru',
                        enableTime: true,
                        time_24hr: true,
                        allowInput: true
                    });
                });
            </script>
        </div>

    @elseif ($field['type'] == 'textarea')

        <div class="form-group">
            <label class="col-md-3 control-label">{{ $field['title'] }}</label>
            <div class="col-md-9">
                {{ Form::textarea($fname, null, array('class' => 'form-control')) }}
                @include('dashboard::widgets.form._help', compact('field'))
            </div>
        </div>

    @elseif ($field['type'] == 'ckeditor')

        <div class="form-group">
            <label class="col-md-3 control-label">{{ $field['title'] }}</label>
            <div class="col-md-9">
                @include('dashboard::widgets.form._help', compact('field'))
                {{ Form::textarea($fname, null, array('class' => 'form-control')) }}
            </div>
        </div>

        <script type="text/javascript">
            var ckeditor = CKEDITOR.replace('{{$fname}}', {
                autoGrow_maxHeight: 800,
                autoGrow_minHeight: 250,
                height: 250
            });
        </script>

    @elseif ($field['type'] == 'bool')

        <div class="form-group">
            <div class="col-md-offset-3 col-md-9">
                <div class="checkbox">
                    <label>
                        {{ Form::hidden($fname, 0) }}
                        {{ Form::checkbox($fname, 1) }} {{ $field['title'] }}
                        @include('dashboard::widgets.form._help', compact('field'))
                    </label>
                </div>
            </div>
        </div>

    @elseif ($field['type'] == 'select')

        @php
        if (!is_array($field['values'])) {
            eval('$tmp = '.$field['values']);
            $field['values'] = $tmp;
        }
        @endphp
        
        <div class="form-group">
            <label class="col-md-3 control-label">{{ $field['title'] }}</label>
            <div class="col-md-9">
                {{ Form::select($fname, $field['values'], null, array('class' => 'form-control')) }}
                @include('dashboard::widgets.form._help', compact('field'))
            </div>
        </div>
        
    @elseif ($field['type'] == 'file')
        
        @if ( empty($model->{$fname}) || !\Storage::exists($model->{$fname}) )

            <div class="form-group">
                <label class="col-md-3 control-label">{{ $field['title'] }}</label>
                <div class="col-md-9">
                    {{ Form::file($fname) }}
                    @include('dashboard::widgets.form._help', compact('field'))
                </div>
            </div>
            
        @else

            <div class="form-group">
                <label class="col-md-3 control-label">{{ $field['title'] }}</label>
                <div class="col-md-9">
                    @php
                        $mime = mime_content_type(public_path($model->{$fname}));
    
                        $img_check = false;
                        if(substr($mime, 0, 5) == 'image') {
                            $img_check = true;
                        }
                    @endphp

                    @if ( $img_check )
                        <a href="{{ $model->{$fname} }}" data-fancybox="form" target="_blank">
                            <img src="{{ resizer($model->{$fname})->make(200, 100) }}">
                        </a>
                    @else
                        <a href="{{ $model->{$fname} }}" target="_blank">
                            Скачать ({{ $model->{$fname} }}) <br>
                        </a>
                    @endif

                    {{ Form::checkbox($fname.'_del', 0, 0, array('id' => $fname.'_del')) }}
                    {{ Form::label($fname.'_del', 'Удалить?') }}
                    {{ Form::hidden($fname, null, array('class' => 'form-control')) }}
                    
                    @include('dashboard::widgets.form._help', compact('field'))
                </div>
            </div>
        @endif

    @elseif ($field['type'] == 'password')


        <div class="form-group">
            <label class="col-md-3 control-label">{{ $field['title'] }}</label>
            <div class="col-md-9">
                {{ Form::text('', '', array('style' => 'display: none;', 'autocomplete' => 'off')) }} {{-- autocomplete disable --}}
                {{ Form::password($fname, array('style' => 'display: none;', 'autocomplete' => 'off')) }} {{-- autocomplete disable --}}
                {{ Form::password($fname, array('class' => 'form-control', 'autocomplete' => 'off')) }}
                @include('dashboard::widgets.form._help', compact('field'))
            </div>
        </div>

    @endif
    
@endforeach
