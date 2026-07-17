<?php

namespace App\Http\Controllers;

use App\Models\Pin;
use Illuminate\Http\Request;

class PinController extends Controller
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
            'image_path'  => '/storage/' . $path,
            'category'    => $data['category'],
            'vibe_tag'    => $data['vibe_tag'] ?? null,
            'is_public'   => $request->boolean('is_public', true),
            'vibe_count'  => 0,
        ]);

        return redirect()->route('home')->with('status', 'Pin uploaded!');
    }

    public function show(Pin $pin)
    {
        $similarPins = Pin::where('is_public', true)
            ->where('id', '!=', $pin->id)
            ->where(function ($q) use ($pin) {
                $q->where('category', $pin->category)
                  ->orWhere('vibe_tag', $pin->vibe_tag);
            })
            ->latest()
            ->limit(10)
            ->get();

        $userVibed = auth()->check()
            ? $pin->vibes()->where('user_id', auth()->id())->exists()
            : false;

        $userBoards = auth()->check()
            ? auth()->user()->boards()->latest()->get()
            : collect();

        return view('pins.show', [
            'pin'         => $pin,
            'similarPins' => $similarPins,
            'userVibed'   => $userVibed,
            'userBoards'  => $userBoards,
        ]);
    }

    public function vibe(Request $request, Pin $pin)
    {
        $alreadyVibed = $pin->vibes()->where('user_id', auth()->id())->exists();

        if (! $alreadyVibed) {
            $pin->vibes()->create(['user_id' => auth()->id()]);
            $pin->increment('vibe_count');
            $vibed = true;
        } else {
            $pin->vibes()->where('user_id', auth()->id())->delete();
            $pin->decrement('vibe_count');
            $vibed = false;
        }

        return response()->json([
            'vibe_count' => $pin->fresh()->vibe_count,
            'vibed'      => $vibed,
        ]);
    }

    public function save(Request $request, Pin $pin)
    {
        $data = $request->validate([
            'board_id'  => ['nullable', 'integer', 'exists:boards,id'],
            'new_board' => ['nullable', 'string', 'max:100', 'required_without:board_id'],
        ]);

        if (! empty($data['board_id'])) {
            $board = auth()->user()->boards()->findOrFail($data['board_id']);
        } else {
            $board = auth()->user()->boards()->create([
                'name'      => $data['new_board'],
                'is_public' => false,
            ]);
        }

        $board->pins()->syncWithoutDetaching([$pin->id]);

        return response()->json([
            'board_name' => $board->name,
        ]);
    }

    public function edit(Pin $pin)
    {
        if ($pin->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pins.edit', [
            'pin' => $pin,
            'categories' => $this->categories,
            'vibeTags'   => $this->vibeTags,
        ]);
    }

    public function update(Request $request, Pin $pin)
    {
        if ($pin->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category'    => ['required', 'string', 'in:' . implode(',', $this->categories)],
            'vibe_tag'    => ['nullable', 'string', 'in:' . implode(',', $this->vibeTags)],
            'is_public'   => ['nullable', 'boolean'],
        ]);

        $pin->update([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'category'    => $data['category'],
            'vibe_tag'    => $data['vibe_tag'] ?? null,
            'is_public'   => $request->boolean('is_public', true),
        ]);

        return redirect()->route('pins.show', $pin)->with('status', 'Pin updated!');
    }

    public function destroy(Pin $pin)
    {
        if ($pin->user_id !== auth()->id()) {
            abort(403);
        }

        $pin->delete();

        return redirect()->route('profile.show')->with('status', 'Pin deleted.');
    }
}