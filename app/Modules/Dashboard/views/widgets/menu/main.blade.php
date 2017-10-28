<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        
        @php $i = 1; @endphp
        
        @foreach ($menu as $num => $group)
            @if ($num > 0)
                <li class="nav-divider"></li>
            @endif
            @if (!empty($group['group']))
                <li class="nav-header nav-header{{ $i }}">{{ $group['group'] }}</li>
                @php $i++; @endphp
            @endif
            @foreach($group['items'] as $item)
                @if ($item['active'])
                    <li class="active"><a href="{{$item['url']}}"><i class="fa fa-fw fa-{{$item['glyph']}}"></i> {{$item['name']}}</a></li>
                @else
                    <li><a href="{{$item['url']}}"><i class="fa fa-fw fa-{{$item['glyph']}}"></i> {{$item['name']}}</a></li>
                @endif
            @endforeach
        @endforeach
    </ul>
</div>
