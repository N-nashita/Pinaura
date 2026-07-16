@extends('layouts.app')

@section('title', $user->name . ' — Pinaura')

@section('content')
<div class="profile-header">
    <div class="profile-avatar">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>
    <div class="profile-info">
        <h1 class="profile-name">{{ $user->name }}</h1>
        <p class="profile-email">{{ $user->email }}</p>
        <p class="profile-pin-count">{{ $pins->total() }} pins</p>
        <a href="{{ route('profile.edit') }}" class="profile-edit-link">edit profile</a>
    </div>
</div>

@if($pins->count())
    <div class="pin-grid">
        @include('partials.pins-grid-items', ['pins' => $pins])
    </div>
@else
    <div class="empty-state">
        <p>no pins yet</p>
        <p>your uploads will show up here</p>
    </div>
@endif
@endsection