@extends('layouts.app')

@section('title', 'Pinaura — find your vibe')

@section('content')

    @if($pins->count())
        <div class="pin-grid">
            @foreach($pins as $pin)
                @include('partials.pin-card', ['pin' => $pin])
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $pins->links() }}
        </div>
    @else
        <div class="empty-state">
            <p>nothing here yet</p>
            <p>add a few rows to the pins table to see them here</p>
        </div>
    @endif

@endsection