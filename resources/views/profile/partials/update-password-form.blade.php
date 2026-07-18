<div class="settings-section">
    <h2 class="settings-section-title">Update Password</h2>
    <p class="settings-section-subtitle">Ensure your account is using a long, random password to stay secure.</p>

    <form method="post" action="{{ route('password.update') }}" class="settings-form">
        @csrf
        @method('put')

        <label for="update_password_current_password" class="auth-label">current password</label>
        <input id="update_password_current_password" name="current_password" type="password" class="auth-input" autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <p class="auth-error"><span>{{ $message }}</span></p>
        @enderror

        <label for="update_password_password" class="auth-label">new password</label>
        <input id="update_password_password" name="password" type="password" class="auth-input" autocomplete="new-password">
        @error('password', 'updatePassword')
            <p class="auth-error"><span>{{ $message }}</span></p>
        @enderror

        <label for="update_password_password_confirmation" class="auth-label">confirm password</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="auth-input" autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <p class="auth-error"><span>{{ $message }}</span></p>
        @enderror

        <div class="settings-form-actions">
            <button type="submit" class="auth-button settings-save-btn">save</button>

            @if (session('status') === 'password-updated')
                <span class="settings-success-text">saved.</span>
            @endif
        </div>
    </form>
</div>