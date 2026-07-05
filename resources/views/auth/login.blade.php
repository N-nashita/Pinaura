<x-guest-layout>
    <div class="auth-header">
        <a href="{{ route('home') }}" class="auth-logo">pinaura</a>
    </div>
    <p class="auth-subtitle">log in to keep pinning</p>

    @if ($errors->any())
        <div class="auth-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <label for="email" class="auth-label">email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="auth-input">

        <label for="password" class="auth-label">password</label>
        <input id="password" type="password" name="password" required class="auth-input">

        <label class="auth-checkbox-row">
            <input type="checkbox" name="remember">
            <span>remember me</span>
        </label>

        <button type="submit" class="auth-button">log in</button>
    </form>

    <p class="auth-footer">
        don't have an account? <a href="{{ route('register') }}">sign up</a>
    </p>
</x-guest-layout>