<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Pincontroller extends Controller
{
    private array $categories = ['travel', 'food', 'art', 'fashion', 'tech', 'fitness', 'study', 'home', 'nature'];
    private array $vibeTags   = ['cozy', 'energetic', 'nostalgic', 'calm', 'bold', 'dreamy'];
 
    public function create()
    {
        return view('pins.create', [
            'categories' => $this->categories,
            'vibeTags'   => $this->vibeTags,
        ]);
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category'    => ['required', 'string', 'in:' . implode(',', $this->categories)],
            'vibe_tag'    => ['nullable', 'string', 'in:' . implode(',', $this->vibeTags)],
            'is_public'   => ['nullable', 'boolean'],
            'image'       => ['required', 'image', 'max:8192'], // 8MB max
        ]);
 
        $path = $request->file('image')->store('pins', 'public');
 
        Pin::create([
            'user_id'     => auth()->id(),
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'image_path'  => 'storage/' . $path,
            'category'    => $data['category'],
            'vibe_tag'    => $data['vibe_tag'] ?? null,
            'is_public'   => $request->boolean('is_public', true),
            'vibe_count'  => 0,
        ]);
 
        return redirect()->route('home')->with('status', 'Pin uploaded!');
    }
}
