<?php

namespace App\Http\Controllers;

use App\Models\Pin;
use Illuminate\Http\Request;

class QuoteCardController extends Controller
{
    public function create()
    {
        return view('design.quote-card');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'quote_text' => ['required', 'string', 'max:500'],
            'image_path' => ['required', 'string', 'max:255'],
            'is_public'  => ['nullable', 'boolean'],
        ]);

        Pin::create([
            'user_id'    => auth()->id(),
            'title'      => 'Quote card',
            'image_path' => $data['image_path'],
            'category'   => 'art',
            'type'       => 'quote',
            'quote_text' => $data['quote_text'],
            'is_public'  => $request->boolean('is_public', true),
            'vibe_count' => 0,
        ]);

        return redirect()->route('home')->with('status', 'Quote card created!');
    }
}