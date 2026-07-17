<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UnsplashController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('q', 'nature');

        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . config('services.unsplash.access_key'),
        ])->get('https://api.unsplash.com/search/photos', [
            'query'    => $query,
            'per_page' => 12,
        ]);

        return $response->json();
    }
}