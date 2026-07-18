@extends('layouts.app')

@section('title', 'Edit Profile — Pinaura')

@section('content')
<div class="settings-page">
    <h2 class="settings-page-title">Profile</h2>

    <div class="settings-card">
        @include('profile.partials.update-avatar-form')
    </div>
    
    <div class="settings-card">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="settings-card">
        @include('profile.partials.update-password-form')
    </div>

    <div class="settings-card">
        @include('profile.partials.delete-user-form')
    </div>

</div>
@endsection