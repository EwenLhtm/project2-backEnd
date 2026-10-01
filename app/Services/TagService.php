<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    public function create(array $data): Tag
    {
        // Créez le tag en utilisant le modèle Tag
        return Tag::create(['name' => $data['name']]);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        // Récupérer tous les tags depuis la base de données
        return Tag::all();
    }

    public function getOneById(Int $id): ?Tag
    {
        // Récupérer un tag spécifique par son ID depuis la base de données
        return Tag::find($id);
    }

    public function update(Int $id,array $data) : Tag
    {
        // Vérifier que le tag existe
        $tag = Tag::find($id);
        if (!$tag) {
            throw new \InvalidArgumentException('Tag not found.');
        }

        // Mettre à jour le tag avec les nouvelles données
        $tag->update(['name' => $data['name']]);

        return $tag;
    }

    public function delete(Int $id): void
    {
        // Vérifier que le tag existe
        $tag = Tag::find($id);
        if (!$tag) {
            throw new \InvalidArgumentException('Tag not found.');
        }

        // Supprimer le tag de la base de données
        $tag->delete();;
    }
}