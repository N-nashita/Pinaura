@extends('layouts.app')

@section('title', 'Your Grids — Pinaura')

@section('content')
<div class="boards-page">
    <h1 class="boards-page-title">Your Grids</h1>
    <p class="boards-page-subtitle">private collections only you can see</p>

    @if($boards->count())
        <div class="boards-list">
            @foreach($boards as $board)
                <a href="{{ route('boards.show', $board) }}" class="board-card">
                    <div class="board-card-preview">
                        @foreach($board->pins()->latest()->limit(4)->get() as $previewPin)
                            <div class="board-card-preview-cell">
                                    <img src="{{ $previewPin->image_path }}" alt="">
                            </div>
                        @endforeach

                        @for($i = $board->pins_count; $i < 4; $i++)
                            <div class="board-card-preview-cell board-card-preview-empty"></div>
                        @endfor
                    </div>

                    <div class="board-card-info">
                        <p class="board-card-name">{{ $board->name }}</p>
                        <p class="board-card-count">{{ $board->pins_count }} {{ Str::plural('pin', $board->pins_count) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <p>no grids yet</p>
            <p>save a pin to a new grid to see it here</p>
        </div>
    @endif
</div>
@endsection