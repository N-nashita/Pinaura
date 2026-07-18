@extends('layouts.app')

@section('title', 'Create a Quote Card — Pinaura')

@section('content')
<div class="create-page">
    <h1 class="create-title">Quote Card</h1>
    <p class="create-subtitle">write something worth saving</p>

    <div class="create-layout">
        <form action="{{ route('quote-card.store') }}" method="POST" class="create-fields" id="quote-form">
            @csrf

            <label for="quote_text" class="auth-label">your quote</label>
            <div class="quote-input-row">
                <textarea
                    id="quote_text"
                    name="quote_text"
                    rows="5"
                    required
                    maxlength="500"
                    class="auth-input create-textarea"
                    placeholder="type something worth remembering..."
                >{{ old('quote_text') }}</textarea>
            </div>

            <button type="button" id="generate-quote-btn" class="generate-quote-btn">✦ Generate a Quote for Me</button>

            @error('quote_text')
                <p class="auth-error"><span>{{ $message }}</span></p>
            @enderror

            <label for="unsplash-query" class="auth-label">search a background</label>
            <div class="unsplash-search-row">
                <input type="text" id="unsplash-query" class="auth-input" placeholder="e.g. cozy autumn">
                <button type="button" id="unsplash-search-btn" class="save-new-board-btn auth-button">search</button>
            </div>

            <div id="unsplash-results" class="unsplash-results"></div>

            <input type="hidden" name="image_path" id="selected-image-path">

            @error('image_path')
                <p class="auth-error"><span>please pick a background photo</span></p>
            @enderror

            <label class="auth-checkbox-row">
                <input type="hidden" name="is_public" value="0">
                <input type="checkbox" name="is_public" value="1" checked>
                make this public
            </label>

            <button type="submit" class="auth-button" id="submit-btn" disabled>save quote card</button>
        </form>

        <div class="quote-preview-box" id="quote-preview-box">
            <p class="quote-preview-text" id="quote-preview-text">your quote will appear here</p>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // live quote text preview
    document.getElementById('quote_text').addEventListener('input', function (e) {
        document.getElementById('quote-preview-text').textContent = e.target.value || 'your quote will appear here';
    });

    // Unsplash search
    document.getElementById('unsplash-search-btn').addEventListener('click', function () {
        const query = document.getElementById('unsplash-query').value.trim();
        if (!query) return;

        const resultsBox = document.getElementById('unsplash-results');
        resultsBox.innerHTML = '<p class="unsplash-loading">searching...</p>';

        fetch(`{{ route('unsplash.search') }}?q=${encodeURIComponent(query)}`, {
            headers: { 'X-CSRF-TOKEN': csrfToken },
        })
            .then((res) => res.json())
            .then((data) => {
                resultsBox.innerHTML = '';

                if (!data.results || data.results.length === 0) {
                    resultsBox.innerHTML = '<p class="unsplash-loading">no results — try another search</p>';
                    return;
                }

                data.results.forEach((photo) => {
                    const thumb = document.createElement('img');
                    thumb.src = photo.urls.small;
                    thumb.className = 'unsplash-thumb';
                    thumb.dataset.fullUrl = photo.urls.regular;

                    thumb.addEventListener('click', function () {
                        document.querySelectorAll('.unsplash-thumb').forEach((t) => t.classList.remove('unsplash-thumb-selected'));
                        thumb.classList.add('unsplash-thumb-selected');

                        document.getElementById('selected-image-path').value = photo.urls.regular;
                        document.getElementById('quote-preview-box').style.backgroundImage = `url(${photo.urls.regular})`;
                        document.getElementById('submit-btn').disabled = false;
                    });

                    resultsBox.appendChild(thumb);
                });
            })
            .catch(() => {
                resultsBox.innerHTML = '<p class="unsplash-loading">something went wrong — try again</p>';
            });
    });

    document.getElementById('generate-quote-btn').addEventListener('click', function () {
        const textarea = document.getElementById('quote_text');
        const preview = document.getElementById('quote-preview-text');

        textarea.disabled = true;
        textarea.placeholder = 'fetching a quote...';

        fetch(`{{ route('quotes.random') }}`, {
            headers: { 'X-CSRF-TOKEN': csrfToken },
        })
            .then((res) => res.json())
            .then((data) => {
                const quoteText = `"${data.content}" — ${data.author}`;
                textarea.value = quoteText;
                preview.textContent = quoteText;
            })
            .catch(() => {
                textarea.placeholder = 'couldn\'t fetch a quote — try again or write your own';
            })
            .finally(() => {
                textarea.disabled = false;
            });
    });   
</script>
@endsection