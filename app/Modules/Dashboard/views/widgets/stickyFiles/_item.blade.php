<div class="drop__file_item {{ $file->is_image() ? 'drop__file_item--image' : '' }}" data-id="{{ $file->id }}">
	<div class="drop__file_item_del glyphicon glyphicon-remove"></div>
	
	@if ($file->is_image())
		<a href="{{ $file->file }}" target="_blank" data-fancybox="sticky_{{ $field }}">
			<img src="{{ resizer($file->file)->make(160, 160) }}">
		</a>
	@else
		<a href="{{ $file->file }}" target="_blank">
			<div class="drop__file_item_in">
				{{ $file->file }}
			</div>
		</a>
	@endif
</div>
