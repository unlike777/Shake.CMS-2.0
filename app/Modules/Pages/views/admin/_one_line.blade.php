<li class="dd-item dd3-item" data-id="{{ $item->id }}">
    <div class="dd-handle dd3-handle">Drag</div>
    <div class="dd3-content">

        @if ($item->active)
            <i class="glyphicon glyphicon-eye-open eye_btn"></i>
        @else
            <i class="glyphicon glyphicon-eye-close eye_btn"></i>
        @endif
        
        @if ($info = $item->info())
            <a href="{{ route('admin.pages.edit', [$item->id]) }}">{{ $item->title }}</a><span>, {{ implode(', ', $info) }}</span>
        @else
            <a href="{{ route('admin.pages.edit', [$item->id]) }}">{{ $item->title }}</a>
        @endif
            
        <div class="dd-right">
            <a href="{{ route('admin.pages.edit', [$item->id]) }}" class="glyphicon glyphicon-pencil"></a>
            <a href="{{ $item->url() }}" class="glyphicon glyphicon-share" target="_blank"></a>
            <a href="{{ route('admin.pages.delete', [$item->id]) }}" class="glyphicon glyphicon-trash table__row_delete js_delete_confirm"></a>
        </div>
    </div>

    @if ($item->pages()->count())
        <ol class="dd-list">
            @foreach($item->pages as $item)
                @include('pages::admin._one_line', compact('item'))
            @endforeach
        </ol>
    @endif
</li>
