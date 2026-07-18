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
            document.addEventListener('DOMContentLoaded', () => {
                const grid = document.getElementById('pin-grid');
                const scroll = document.getElementById('scroll');

                if (!grid || !scroll) {
                    return;
                }

                let nextPageUrl = scroll.dataset.nextPageUrl || null;
                let isLoading = false;
                const preloadDistance = 400;

                const shouldPreloadMore = () => {
                    const rect = scroll.getBoundingClientRect();
                    return rect.top <= window.innerHeight + preloadDistance;
                };

                if (!nextPageUrl) {
                    scroll.style.display = 'none';
                    return;
                }

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            loadMore();
                        }
                    });
                }, { rootMargin: '400px' });

                observer.observe(scroll);

                function loadMore() {
                    if (!nextPageUrl || isLoading) {
                        return;
                    }

                    isLoading = true;
                    scroll.classList.add('scroll-loading-active');

                    fetch(nextPageUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    })
                        .then((res) => res.json())
                        .then((data) => {
                            if (data.html) {
                                grid.insertAdjacentHTML('beforeend', data.html);
                            }

                            nextPageUrl = data.next_page_url || null;
                            scroll.dataset.nextPageUrl = nextPageUrl || '';

                            if (!nextPageUrl) {
                                observer.unobserve(scroll);
                                scroll.style.display = 'none';
                                return;
                            }

                            if (shouldPreloadMore()) {
                                window.requestAnimationFrame(() => {
                                    loadMore();
                                });
                            }
                        })
                        .catch(() => {
                            const loadingText = scroll.querySelector('.scroll-loading');

                            if (loadingText) {
                                loadingText.textContent = 'couldn\'t load more — scroll to retry';
                            }
                        })
                        .finally(() => {
                            isLoading = false;
                            scroll.classList.remove('scroll-loading-active');
                        });
                }
            });
        </script>

    @else
        <div class="empty-state">
            <p>nothing here yet</p>
            <p>add a few rows to the pins table to see them here</p>
        </div>
    @endif

@endsection