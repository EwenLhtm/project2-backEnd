<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NoteService;
use App\Http\Requests\NoteRequest;

class NoteController extends Controller
{
    public function create(NoteRequest $request, NoteService $noteService)
    {
        $data = $request->validated();
        $noteService->create($data);

        return redirect()->back();
    }

    public function getAll(NoteService $noteService)
    {
        $notes = $noteService->getAll();

        return response()->json($notes);
    }

    public function getOneById(Int $id, NoteService $noteService)
    {
        $note = $noteService->getOneById($id);

        if (!$note) {
            return response()->json(['message' => 'Note not found.'], 404);
        }

        return response()->json($note);
    }

    public function update(Int $id, NoteRequest $request, NoteService $noteService)
    {
        $data = $request->validated();
        try {
            $noteService->update($id, $data);
            return redirect()->back();
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function delete(Int $id, NoteService $noteService)
    {
        try {
            $noteService->delete($id);
            return redirect()->back();
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
