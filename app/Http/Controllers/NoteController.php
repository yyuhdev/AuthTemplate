<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user()->notes);
    }

    public function store(Request $request)
    {
        $note = Note::create([
            'user_id' => Auth::id(),
            'text' => $request->text,
            'pos_x'   => $request->pos_x ?? 100,
            'pos_y'   => $request->pos_y ?? 100,
            'width'   => $request->width ?? 300,
            'height'  => $request->height ?? 200,
        ]);

        return response()->json($note);
    }

    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => "You can't edit someone else's note",
            ], 403);
        }

        $note->update($request->only([
            'text', 'pos_x', 'pos_y', 'width', 'height'
        ]));

        return response()->json($note);
    }

    public function destroy(Request $request, Note $note)
    {
        if ($note->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => "You can't edit someone else's note",
            ], 403);
        }
        $note->delete();

        return response()->json(['status' => 'deleted']);
    }
}
