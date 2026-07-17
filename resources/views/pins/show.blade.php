@extends('layouts.app')

@section('title', $pin->title . ' — Pinaura')

@section('content')
<div class="pin-detail">

    <div class="pin-detail-image">
        <img src="{{ $pin->image_path }}" alt="{{ $pin->title }}">
        @if($pin->type === 'quote')
            <div class="pin-detail-quote-overlay">
                <p class="pin-detail-quote-text">{{ $pin->quote_text }}</p>
            </div>
        @endif
    </div>

    <div class="pin-detail-info">

        <div class="pin-detail-top">
            @if($pin->vibe_tag)
                <span class="vibe-stamp-static">
                    <span class="vibe-stamp-icon">✦</span>
                    <span class="vibe-stamp-label">{{ $pin->vibe_tag }}</span>
                </span>
            @endif
            <span class="pin-detail-category">{{ $pin->category }}</span>
        </div>

        <h1 class="pin-detail-title">{{ $pin->title }}</h1>

        @if($pin->description)
            <p class="pin-detail-description">{{ $pin->description }}</p>
        @endif

        @if($pin->user)
            <div class="pin-detail-creator">
                <span class="pin-detail-creator-avatar">{{ strtoupper(substr($pin->user->name, 0, 1)) }}</span>
                <span>{{ $pin->user->name }}</span>
            </div>
        @endif

        <div class="pin-detail-actions">

            {{-- Vibe button --}}
            <button
                type="button"
                id="vibe-btn"
                class="pin-action-btn {{ $userVibed ? 'pin-action-btn-active' : '' }}"
                data-vibed="{{ $userVibed ? '1' : '0' }}"
                data-pin-id="{{ $pin->id }}"
                {{ auth()->check() ? '' : 'title=log in to vibe' }}
            >
                <span class="pin-action-icon">✦</span>
                <span id="vibe-count-label">{{ $pin->vibe_count }} vibes</span>
            </button>

            {{-- Save / add to grid --}}
            <div class="save-wrap">
                <button type="button" id="save-btn" class="pin-action-btn" {{ auth()->check() ? '' : 'title=log in to save' }}>
                    <span class="pin-action-icon">＋</span>
                    <span>add to grid</span>
                </button>

                @auth
                    <div class="save-dropdown" id="save-dropdown" style="display:none;">
                        @if($userBoards->count())
                            <p class="save-dropdown-label">save to an existing grid</p>
                            @foreach($userBoards as $board)
                                <button type="button" class="save-board-option" data-board-id="{{ $board->id }}">
                                    {{ $board->name }}
                                </button>
                            @endforeach
                            <div class="save-dropdown-divider"></div>
                        @endif

                        <p class="save-dropdown-label">or create a new grid</p>
                        <div class="save-new-board">
                            <input type="text" id="new-board-name" placeholder="name your grid" class="auth-input">
                            <button type="button" id="create-board-btn" class="auth-button save-new-board-btn">create &amp; save</button>
                        </div>

                        <p class="save-dropdown-hint">grids are private by default — only you can see them</p>
                    </div>
                @endauth
            </div>
        </div>

        <p id="save-feedback" class="save-feedback" style="display:none;"></p>

    </div>
</div>

@if($similarPins->count())
    <div class="similar-pins-section">
        <h2 class="similar-pins-title">more like this</h2>
        <div class="pin-grid">
            @foreach($similarPins as $similar)
                @include('partials.pin-card', ['pin' => $similar])
            @endforeach
        </div>
    </div>
@endif

@auth
<script>
    (function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Vibe toggle
        const vibeBtn = document.getElementById('vibe-btn');
        vibeBtn.addEventListener('click', function () {
            const pinId = vibeBtn.dataset.pinId;

            fetch(`/pins/${pinId}/vibe`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    document.getElementById('vibe-count-label').textContent = data.vibe_count + ' vibes';
                    vibeBtn.classList.toggle('pin-action-btn-active', data.vibed);
                    vibeBtn.dataset.vibed = data.vibed ? '1' : '0';
                });
        });

        // Save dropdown
        const saveBtn = document.getElementById('save-btn');
        const dropdown = document.getElementById('save-dropdown');

        saveBtn.addEventListener('click', function () {
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        });

        function showFeedback(message) {
            const el = document.getElementById('save-feedback');
            el.textContent = message;
            el.style.display = 'block';
            dropdown.style.display = 'none';
        }

        function savePin(payload) {
            const pinId = vibeBtn.dataset.pinId;

            fetch(`/pins/${pinId}/save`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((data) => {
                    showFeedback(`saved to "${data.board_name}"`);
                })
                .catch(() => showFeedback('something went wrong — try again'));
        }

        document.querySelectorAll('.save-board-option').forEach((btn) => {
            btn.addEventListener('click', function () {
                savePin({ board_id: this.dataset.boardId });
            });
        });

        document.getElementById('create-board-btn').addEventListener('click', function () {
            const name = document.getElementById('new-board-name').value.trim();
            if (!name) return;
            savePin({ new_board: name });
        });
    })();
</script>
@endauth
@endsection