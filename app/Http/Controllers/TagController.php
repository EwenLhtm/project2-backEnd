<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagService;
use App\Http\Requests\TagRequest;

class TagController extends Controller
{
    /**
     * Créer une nouvelle étiquette.
     */
    public function create(TagRequest $request, TagService $TagService)
    {
        $data = $request->validated();
        $newTag = $TagService->create($data);

        return response()->json($newTag, 201);
    }

    /**
     * Récupérer toutes les étiquettes.
     */
    public function getAll(TagService $TagService)
    {
        $tags = $TagService->getAll();

        return response()->json($tags);
    }

    /**
     * Récupérer une étiquette spécifique par son ID.
     */
    public function getOneById(Int $id, TagService $TagService)
    {
        $tag = $TagService->getOneById($id);

        if (!$tag) {
            return response()->json(['message' => 'Tag not found.'], 404);
        }

        return response()->json($tag);
    }

    /**
     * Mettre à jour une étiquette spécifique par son ID.
     */
    public function update(Int $id, TagRequest $request, TagService $TagService)
    {
        $data = $request->validated();

        try {
            $TagService->update($id, $data);
            return response()->json(['message' => 'Tag updated successfully.']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Supprimer une étiquette spécifique par son ID.
     */
    public function delete(Int $id, TagService $TagService)
    {
        try {
            $TagService->delete($id);
            return response()->json(['message' => 'Tag deleted successfully.']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
