<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
     public function index(Request $request)
    {
        $boards = $request->user()
            ->boards()
            ->withCount('pins')
            ->latest()
            ->get();

        return view('boards.index', [
            'boards' => $boards,
        ]);
    }

     public function show(Board $board)
    {
        if ($board->user_id !== auth()->id()) {
            abort(403);
        }

        $pins = $board->pins()->latest()->paginate(24);

        return view('boards.show', [
            'board' => $board,
            'pins'  => $pins,
        ]);
    }
}
