<div class="settings-section">
    <h2 class="settings-section-title">Profile Information</h2>
    <p class="settings-section-subtitle">Update your account's profile information and email address.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="settings-form">
        @csrf
        @method('patch')

        <label for="name" class="auth-label">name</label>
        <input id="name" name="name" type="text" class="auth-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <p class="auth-error"><span>{{ $message }}</span></p>
        @enderror

        <label for="email" class="auth-label">email</label>
        <input id="email" name="email" type="email" class="auth-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <p class="auth-error"><span>{{ $message }}</span></p>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <p class="settings-verify-notice">
                your email address is unverified.
                <button form="send-verification" class="settings-inline-link">click here to re-send the verification email.</button>
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="settings-success-text">a new verification link has been sent to your email address.</p>
            @endif
        @endif

        <div class="settings-form-actions">
            <button type="submit" class="auth-button settings-save-btn">save</button>

            @if (session('status') === 'profile-updated')
                <span class="settings-success-text">saved.</span>
            @endif
        </div>
    </form>
</div>