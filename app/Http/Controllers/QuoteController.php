<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuoteController extends Controller
{
    public function random()
    {
        $response = Http::get('https://zenquotes.io/api/random');

        $data = $response->json();

        if (! $data || ! isset($data[0])) {
            return response()->json(['error' => 'no quote available'], 500);
        }

        return response()->json([
            'content' => $data[0]['q'],
            'author'  => $data[0]['a'],
        ]);
    }

    public function palette(Request $request)
    {
        $hex = ltrim($request->query('hex', '6C33F7'), '#');

        $response = Http::get('https://www.thecolorapi.com/scheme', [
            'hex'    => $hex,
            'mode'   => 'analogic',
            'count'  => 5,
        ]);

        $data = $response->json();

        if (! $data || ! isset($data['colors'])) {
            return response()->json(['error' => 'no palette available'], 500);
        }

        $colors = collect($data['colors'])->map(fn ($c) => $c['hex']['value'])->values();

        return response()->json(['colors' => $colors]);
    }
}