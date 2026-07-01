<div class="filter-bar">

    <a href="{{ route('home', ['q' => request('q')]) }}"
       class="chip {{ !request('category') && !request('vibe') ? 'chip-active-all' : '' }}">
        all
    </a>

    <span class="chip-divider"></span>

    @foreach($categories as $category)
        <a href="{{ route('home', array_filter(['category' => $category, 'vibe' => request('vibe'), 'q' => request('q')])) }}"
           class="chip {{ request('category') === $category ? 'chip-active-category' : '' }}">
            {{ $category }}
        </a>
    @endforeach

    <span class="chip-divider"></span>

    @foreach($vibeTags as $vibe)
        <a href="{{ route('home', array_filter(['vibe' => $vibe, 'category' => request('category'), 'q' => request('q')])) }}"
           class="chip {{ request('vibe') === $vibe ? 'chip-active-vibe' : '' }}">
            #{{ $vibe }}
        </a>
    @endforeach

</div>
