@extends('layouts.app')

@section('title', 'Create a pin — Pinaura')

@section('content')
<div class="create-page">
    <h1 class="create-title">create a pin</h1>
    <p class="create-subtitle">share something that made you feel a certain way</p>

    @if ($errors->any())
        <div class="auth-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('pins.store') }}" enctype="multipart/form-data" class="create-form">
        @csrf

        <div class="create-layout">

            {{-- Image upload + live preview --}}
            <div class="upload-box" id="upload-box">
                <input type="file" name="image" id="image-input" accept="image/*" required class="upload-input">
                <label for="image-input" class="upload-label" id="upload-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="upload-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L7 9m5-5l5 5M5 20h14"/>
                    </svg>
                    <span>choose a photo to upload</span>
                    <span class="upload-hint">JPG or PNG, up to 8MB</span>
                </label>
                <img id="upload-preview" class="upload-preview" style="display:none;" alt="preview">
            </div>

            {{-- Fields --}}
            <div class="create-fields">
                <label for="title" class="auth-label">title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required class="auth-input" placeholder="give it a title">

                <label for="description" class="auth-label">description</label>
                <textarea id="description" name="description" rows="4" class="auth-input create-textarea" placeholder="what's the story behind this?">{{ old('description') }}</textarea>

                <label for="category" class="auth-label">category</label>
                <select id="category" name="category" required class="auth-input">
                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>choose a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>

                <label for="vibe_tag" class="auth-label">vibe tag</label>
                <select id="vibe_tag" name="vibe_tag" class="auth-input">
                    <option value="">no vibe tag</option>
                    @foreach($vibeTags as $vibe)
                        <option value="{{ $vibe }}" {{ old('vibe_tag') === $vibe ? 'selected' : '' }}>{{ $vibe }}</option>
                    @endforeach
                </select>

                <label class="auth-checkbox-row create-visibility">
                    <input type="hidden" name="is_public" value="0">
                    <input type="checkbox" name="is_public" value="1" checked>
                    <span>make this pin public</span>
                </label>

                <button type="submit" class="auth-button">upload pin</button>
            </div>

        </div>
    </form>
</div>

<script>
    const imageInput = document.getElementById('image-input');
    const preview = document.getElementById('upload-preview');
    const label = document.getElementById('upload-label');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            label.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection