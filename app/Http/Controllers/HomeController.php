<?php

namespace App\Http\Controllers;

use App\Models\pin;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $pins = Pin::query()
            ->where('is_public', true)
            ->when($request->filled('category'), fn ($q) =>
                $q->where('category', $request->string('category'))
            )
            ->when($request->filled('vibe'), fn ($q) =>
                $q->where('vibe_tag', $request->string('vibe'))
            )
            ->when($request->filled('q'), fn ($q) =>
                $q->where(function ($sub) use ($request) {
                    $term = $request->string('q');
                    $sub->where('title', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                })
            )
            ->latest()
            ->paginate(24)
            ->withQueryString();
 
        $categories = Pin::where('is_public', true)->distinct()->pluck('category');
        $vibeTags   = Pin::where('is_public', true)->whereNotNull('vibe_tag')->distinct()->pluck('vibe_tag');
 
        return view('home', compact('pins', 'categories', 'vibeTags'));
    }
}
