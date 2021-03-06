@if ($model->exists && $model->enableSticky)

	<div class="col-md-9">
		<div class="col-md-3"></div>
		<div class="col-md-9">
			<div class="clear"></div>

			@foreach($model->getAjaxFields() as $field => $fname)

				<br><br>
				<div class="clear"></div>

				<h4>{{ $fname }}</h4>

				<div class="drop" data-id="{{ $model->id }}" data-field="{{ $field }}" data-model="{{ get_class($model) }}">
					<div class="drop__zone_wr">
						<div class="drop__zone">
							Для загрузки, перетащите файлы сюда
						</div>
					</div>

					<div class="drop__file_list">
						@foreach($model->stickyFiles($field)->orderBy('sort')->get() as $file)
							@include('dashboard::widgets.stickyFiles._item', ['file' => $file, 'field' => $field])
						@endforeach
						{{--<div class="drop__file_item"></div>--}}
					</div>

					<div class="clear"></div>
				</div>

			@endforeach
		</div>
	</div>

@endif
