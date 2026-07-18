<div class="settings-section">
    <h2 class="settings-section-title">Delete Account</h2>
    <p class="settings-section-subtitle">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please backup any data or information that you wish to retain.</p>

    <button type="button" id="show-delete-panel-btn" class="delete-pin-btn">delete account</button>

    <div id="delete-account-panel" class="settings-delete-panel" style="display:none;">
        <h3 class="settings-delete-panel-title">are you sure you want to delete your account?</h3>
        <p class="settings-section-subtitle">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <label for="delete_password" class="auth-label sr-only">password</label>
            <input id="delete_password" name="password" type="password" class="auth-input" placeholder="password">
            @error('password', 'userDeletion')
                <p class="auth-error"><span>{{ $message }}</span></p>
            @enderror

            <div class="settings-form-actions">
                <button type="button" id="cancel-delete-btn" class="settings-cancel-btn">cancel</button>
                <button type="submit" class="delete-pin-btn">delete account</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        const showBtn = document.getElementById('show-delete-panel-btn');
        const cancelBtn = document.getElementById('cancel-delete-btn');
        const panel = document.getElementById('delete-account-panel');

        showBtn.addEventListener('click', function () {
            panel.style.display = 'block';
            showBtn.style.display = 'none';
        });

        cancelBtn.addEventListener('click', function () {
            panel.style.display = 'none';
            showBtn.style.display = 'inline-flex';
        });
    })();
</script>