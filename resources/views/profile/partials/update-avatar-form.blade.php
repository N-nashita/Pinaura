<div class="settings-section">
    <h2 class="settings-section-title">Avatar</h2>
    <p class="settings-section-subtitle">Choose how your profile picture looks across Pinaura.</p>

    <form method="post" action="{{ route('avatar.update') }}" class="settings-form">
        @csrf
        @method('patch')

        <div class="avatar-style-grid">
            <label class="avatar-style-option">
                <input type="radio" name="avatar_style" value="" {{ old('avatar_style', $user->avatar_style) === null ? 'checked' : '' }}>
                <div class="avatar-style-preview avatar-style-initials">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <span>initials</span>
            </label>

            @foreach(['thumbs', 'bottts', 'adventurer', 'shapes', 'micah'] as $style)
                <label class="avatar-style-option">
                    <input type="radio" name="avatar_style" value="{{ $style }}" {{ old('avatar_style', $user->avatar_style) === $style ? 'checked' : '' }}>
                    <img src="https://api.dicebear.com/9.x/{{ $style }}/svg?seed={{ urlencode($user->email) }}" alt="{{ $style }}" class="avatar-style-preview">
                    <span>{{ $style }}</span>
                </label>
            @endforeach
        </div>

        <div class="settings-form-actions">
            <button type="submit" class="auth-button settings-save-btn">save avatar</button>

            @if (session('status') === 'avatar-updated')
                <span class="settings-success-text">saved.</span>
            @endif
        </div>
    </form>
</div>