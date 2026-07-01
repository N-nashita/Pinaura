{{-- $pin: title, image_path, category, vibe_tag, vibe_count --}}
<div class="pin-card">

    <img src="{{ $pin->image_path }}" alt="{{ $pin->title }}" loading="lazy">

    <div class="pin-card-overlay"></div>

    @if($pin->vibe_tag)
        <div class="vibe-stamp">
            <span class="vibe-stamp-icon">✦</span>
            <span class="vibe-stamp-label">{{ $pin->vibe_tag }}</span>
        </div>
    @endif

    <div class="vibe-count">{{ $pin->vibe_count }} vibes</div>

    <div class="pin-card-info">
        <p class="pin-title">{{ $pin->title }}</p>
        <p class="pin-category">{{ $pin->category }}</p>
    </div>
</div>