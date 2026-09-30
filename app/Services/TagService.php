<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    public function create(array $data): Tag
    {
        // Créez le tag en utilisant le modèle Tag
        $newTag = Tag::create(['name' => $data['name']]);

        // Ajoutez le nouveau tag à la bdd
        session()->flash('message', 'Tag added!');

        return $newTag;
    }

    public function getAll()
    {
        // Récupérer tous les tags depuis la base de données
        return Tag::all();
    }

    public function getOneById(Int $id)
    {
        // Récupérer un tag spécifique par son ID depuis la base de données
        return Tag::find($id);
    }

    public function update(Int $id, $data)
    {
        // Vérifier que le tag existe
        $tag = Tag::find($id);
        if (!$tag) {
            throw new \InvalidArgumentException('Tag not found.');
        }

        // Mettre à jour le tag avec les nouvelles données
        $tag->update(['name' => $data['name']]);

        // Ajouter un message flash pour indiquer que la mise à jour a réussi
        session()->flash('message', 'Tag updated!');
    }

    public function delete(Int $id)
    {
        // Vérifier que le tag existe
        $tag = Tag::find($id);
        if (!$tag) {
            throw new \InvalidArgumentException('Tag not found.');
        }

        // Supprimer le tag de la base de données
        $tag->delete();

        // Ajouter un message flash pour indiquer que la suppression a réussi
        session()->flash('message', 'Tag deleted!');
    }
}