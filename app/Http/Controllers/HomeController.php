<?php

namespace App\Http\Controllers;

use App\Models\Pin;
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
 
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.pins-grid-items', compact('pins'))->render(),
                'next_page_url' => $pins->nextPageUrl(),
            ]);
        }
 
        return view('home', compact('pins'));
    }
}
