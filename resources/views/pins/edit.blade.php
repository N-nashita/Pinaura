@extends('layouts.app')

@section('title', 'Edit ' . $pin->title . ' — Pinaura')

@section('content')
<div class="create-page">
    <div class="edit-page-header">
        <div>
            <h1 class="create-title">Edit Pin</h1>
            <p class="create-subtitle">update the details</p>
        </div>

        <form action="{{ route('pins.destroy', $pin) }}" method="POST" onsubmit="return confirm('Delete this pin permanently? This can\'t be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-pin-btn">delete this pin</button>
        </form>
    </div>

    <div class="create-layout">
        <form action="{{ route('pins.update', $pin) }}" method="POST" class="create-fields">
            @csrf
            @method('PUT')

            <label for="title" class="auth-label">title</label>
            <input type="text" id="title" name="title" required maxlength="255" class="auth-input" value="{{ old('title', $pin->title) }}">

            <label for="description" class="auth-label">description</label>
            <textarea id="description" name="description" rows="4" class="auth-input create-textarea">{{ old('description', $pin->description) }}</textarea>

            <label for="category" class="auth-label">category</label>
            <select id="category" name="category" required class="auth-input">
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ old('category', $pin->category) === $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>

            <label for="vibe_tag" class="auth-label">vibe tag</label>
            <select id="vibe_tag" name="vibe_tag" class="auth-input">
                <option value="">no vibe tag</option>
                @foreach($vibeTags as $vibe)
                    <option value="{{ $vibe }}" {{ old('vibe_tag', $pin->vibe_tag) === $vibe ? 'selected' : '' }}>{{ $vibe }}</option>
                @endforeach
            </select>

            <label class="auth-checkbox-row">
                <input type="hidden" name="is_public" value="0">
                <input type="checkbox" name="is_public" value="1" {{ old('is_public', $pin->is_public) ? 'checked' : '' }}>
                make this public
            </label>

            <button type="submit" class="auth-button">save changes</button>
        </form>

        <div class="pin-detail-image">
                <img src="{{ $pin->image_path }}" alt="{{ $pin->title }}">
        </div>
    </div>
</div>
@endsection