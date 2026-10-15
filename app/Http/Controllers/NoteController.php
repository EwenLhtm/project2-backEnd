<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NoteService;
use App\Http\Requests\NoteRequest;

class NoteController extends Controller
{
    /**
     * Créer une nouvelle note.
     */
    public function create(NoteRequest $request, NoteService $noteService)
    {
        $data = $request->validated();

        try {
            $newNote =$noteService->create($data);

            return response()->json([
                'message' => 'Note created successfully.',
                'note' => $newNote
            ], 201);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create note.',
                "error" => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Récupérer toutes les notes.
     */
    public function getAll(NoteService $noteService, Request $request)
    {
        try {
            $notes = $noteService->getAll($request->user()->id);

            return response()->json([
                'message' => 'Notes retrieved successfully.',
                'notes' => $notes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve notes.',
                "error" => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Récupérer une note spécifique par son ID.
     */
    public function getOneById(Int $id, NoteService $noteService)
    {
        try {
            $note = $noteService->getOneById($id);

            if (!$note) {
                return response()->json(['message' => 'Note not found.'], 404);
            }

            return response()->json([
                'message' => 'Note found.',
                'note' => $note
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve note.',
                "error" => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Mettre à jour une note spécifique par son ID.
     */
    public function update(Int $id, NoteRequest $request, NoteService $noteService)
    {
        $data = $request->validated();
        try {
            $noteService->update($id, $data);
            return response()->json([
                'message' => 'Note updated successfully.',
                'note' => $data
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Supprimer une note spécifique par son ID.
     */
    public function delete(Int $id, NoteService $noteService)
    {
        try {
            $noteService->delete($id);
            return response()->json([
                'message' => 'Note deleted successfully.'
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
