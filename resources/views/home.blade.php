@extends('layouts.app')

@section('title', 'Pinaura — find your vibe')

@section('content')

    @if($pins->count())
        <div class="pin-grid" id="pin-grid">
                @include('partials.pins-grid-items', ['pins' => $pins])
        </div>

        <div class="scroll" id="scroll" data-next-page-url="{{ $pins->nextPageUrl() }}">
            <span class="scroll-loading">Loading more pins...</span>
        </div>

        <script>
            const grid = document.getElementById('pin-grid');
            const scroll = document.getElementById('scroll');
            let nextPageUrl = scroll.dataset.nextPageUrl || null;
            let isLoading = false;

            if(!nextPageUrl) {
                scroll.style.display = 'none';
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && nextPageUrl && !isLoading) {
                        const nextPageUrl = scroll.getAttribute('data-next-page-url');
                        if (nextPageUrl)
                            loadMore();
                    }
                });
            }, { rootMargin: '400px' });
 
            observer.observe(scroll);
 
            function loadMore() {
                isLoading = true;
                scroll.classList.add('scroll-loading-active');
 
                fetch(nextPageUrl, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then((res) => res.json())
                    .then((data) => {
                        grid.insertAdjacentHTML('beforeend', data.html);
                        nextPageUrl = data.next_page_url;
                        scroll.dataset.nextPageUrl = nextPageUrl || '';
 
                        if (!nextPageUrl) {
                            observer.unobserve(scroll);
                            scroll.style.display = 'none';
                        }
                    })
                    .catch(() => {
                        scroll.querySelector('.scroll-loading').textContent = 'couldn\'t load more — scroll to retry';
                        })
                    .finally(() => {
                        isLoading = false;
                        scroll.classList.remove('scroll-loading-active');
                        });
                }
            })();
        </script>

    @else
        <div class="empty-state">
            <p>nothing here yet</p>
            <p>add a few rows to the pins table to see them here</p>
        </div>
    @endif

@endsection