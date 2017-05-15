@if (count($fields) > 0)

<div class="filter bg-warning">
	
	{{ Form::open([ 'url' => request()->url().'?'.del_from_query(['page']) ]) }}
	
	@foreach($fields as $fname => $field)
		
		@if ($field['type'] == 'text' || $field['type'] == 'not_editable')
			
			<div class="col-xs-2">
				<div class="form-group">
					{{ Form::label($fname, $field['title']) }}
					{{ Form::text($fname, $field['value'], ['class' => 'form-control']) }}
				</div>
			</div>
		
		{{--@elseif ($field['type'] == 'bool')--}}
			{{----}}
			{{--<div class="col-xs-6">--}}
				{{--<div class="form-group">--}}
					{{--{{ Form::label($fname, $field['title']) }}--}}
					{{--{{ Form::checkbox($fname, 1) }}--}}
				{{--</div>--}}
			{{--</div>--}}
			{{----}}
		{{--@elseif ($field['type'] == 'textarea')--}}
			{{----}}
			{{--<div class="col-xs-12">--}}
				{{--<div class="form-group">--}}
					{{--{{ Form::label($fname, $field['title']) }}--}}
					{{--{{ Form::textarea($fname, null, array('class' => 'form-control')) }}--}}
				{{--</div>--}}
			{{--</div>--}}
			{{----}}
			
		@elseif ($field['type'] == 'select')
		
			<?
				if (!is_array($field['values'])) {
					eval('$tmp = '.$field['values']);
					$field['values'] = $tmp;
				}
				
				foreach ($field['values'] as $val) {
					if ($val !== '') {
						$field['values'] = ['' => ''] + $field['values'];
					}
					break;
				}
			?>
			
			<div class="col-xs-2">
				<div class="form-group">
					{{ Form::label($fname, $field['title']) }}
					{{ Form::select($fname, $field['values'], $field['value'], ['class' => 'form-control']) }}
				</div>
			</div>
			
			
		@elseif ($field['type'] == 'bool')
        		
			<div class="col-xs-2">
				<div class="form-group">
				
					<?
						//если поле булево, слегка меняем значение 
						if ($field['value'] === 0) {
							$field['value'] = 2;
						}
					?>
					
					{{ Form::label($fname, $field['title']) }}
					{{ Form::select($fname, [0 => '', 1 => 'Да', 2 => 'Нет'], $field['value'], ['class' => 'form-control']) }}
				</div>
			</div>
			
		@endif
		
	@endforeach
		
	<div class="clear"></div>
	
	<div class="col-xs-4">
		{{ Form::submit('Фильтровать', ['class' => 'btn btn-warning btn-xs', 'name' => 'filter[apply]']) }}
		&nbsp;&nbsp;
		{{ Form::submit('Сбросить', ['class' => 'btn btn-info btn-xs', 'name' => 'filter[reset]']) }}
	</div>
		
	{{ Form::close() }}
	
	<div class="clear"></div>
</div>

<br>

@endif
