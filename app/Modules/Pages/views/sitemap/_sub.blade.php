<ul>
    @foreach($pages as $page)
        <li>
            <a href="{{ $page->url() }}">{{ $page->title }}</a>
            @if ($pages = $page->pages()->publ()->get())
                @include('pages::sitemap._sub')
            @endif
        </li>
    @endforeach
</ul>
