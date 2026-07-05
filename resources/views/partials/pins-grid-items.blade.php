@foreach($pins as $pin)
    @include('partials.pin-card', ['pin' => $pin])
@endforeach