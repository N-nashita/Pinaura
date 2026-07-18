@extends('layouts.app')

@section('title', $board->name . ' — Pinaura')

@section('content')
<div class="board-header">
    <a href="{{ route('boards.index') }}" class="board-back-link">← your grids</a>
    <h1 class="board-title">{{ $board->name }}</h1>
    <p class="board-subtitle">{{ $pins->total() }} {{ Str::plural('pin', $pins->total()) }} · private</p>
</div>

@if($pins->count())
    <div class="pin-grid">
        @include('partials.pins-grid-items', ['pins' => $pins])
    </div>
@else
    <div class="empty-state">
        <p>this grid is empty</p>
        <p>save pins here from any pin's page</p>
    </div>
@endif
@endsection