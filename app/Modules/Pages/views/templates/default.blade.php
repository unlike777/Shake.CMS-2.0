@extends('pages::layouts.main')

@section('content')

<h1>Шаблон Станартный - {{ $item->title }}</h1>
    
<div>
    {!! $item->content !!}
</div>
    
@endsection
