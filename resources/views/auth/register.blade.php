<x-guest-layout>
    <div class="auth-header">
        <a href="{{ route('home') }}" class="auth-logo">pinaura</a>
    </div>
    <p class="auth-subtitle">create an account to start pinning</p>

    @if ($errors->any())
        <div class="auth-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <label for="name" class="auth-label">name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="auth-input">

        <label for="email" class="auth-label">email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="auth-input">

        <label for="password" class="auth-label">password</label>
        <input id="password" type="password" name="password" required class="auth-input">

        <label for="password_confirmation" class="auth-label">confirm password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required class="auth-input">

        <button type="submit" class="auth-button">create account</button>
    </form>

    <p class="auth-footer">
        already have an account? <a href="{{ route('login') }}">log in</a>
    </p>
</x-guest-layout>