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

        try {
            $newTag = $TagService->create($data);

            return response()->json([
                'message' => 'Tag created successfully.',
                'tag' => $newTag
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create tag.',
                "error" => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Récupérer toutes les étiquettes.
     */
    public function getAll(TagService $TagService)
    {
        try {
            $tags = $TagService->getAll();

            return response()->json([
                'message' => 'Tags retrieved successfully.',
                'tags' => $tags
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve tags.',
                "error" => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Récupérer une étiquette spécifique par son ID.
     */
    public function getOneById(Int $id, TagService $TagService)
    {
        try {
            $tag = $TagService->getOneById($id);

            if (!$tag) {
                return response()->json(['message' => 'Tag not found.'], 404);
            }

            return response()->json([
                'message' => 'Tag found.',
                'tag' => $tag
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve tag.',
                "error" => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Mettre à jour une étiquette spécifique par son ID.
     */
    public function update(Int $id, TagRequest $request, TagService $TagService)
    {
        $data = $request->validated();

        try {
            $tag = $TagService->update($id, $data);
            return response()->json([
                'message' => 'Tag updated successfully.',
                'tag' => $tag
            ]);
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
            return response()->json([
                'message' => 'Tag deleted successfully.'
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
