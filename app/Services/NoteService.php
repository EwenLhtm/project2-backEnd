<?php

namespace App\Services;

use App\Models\Note;

class NoteService
{
    public function create(array $data): Note
    {
        // Créez la note en utilisant le modèle Note
        return Note::create([
            'user_id' => $data['user_id'],
            'tag_id' => $data['tag_id'],
            'text' => $data['text'],
        ]);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        // Récupérer toutes les notes depuis la base de données
        return Note::all();
    }

    public function getOneById(Int $id): ?Note
    {
        // Récupérer une note spécifique par son ID depuis la base de données
        return Note::find($id);
    }

    public function update(Int $id, array $data): Note
    {
        // Vérifier que la note existe
        $note = Note::find($id);
        if (!$note) {
            throw new \InvalidArgumentException('Note not found.');
        }

        // Mettre à jour la note avec les nouvelles données
        $note->update([
            'user_id' => $data['user_id'],
            'tag_id' => $data['tag_id'],
            'text' => $data['text'],
        ]);

        return $note;
    }

    public function delete(Int $id): void
    {
        // Vérifier que la note existe
        $note = Note::find($id);
        if (!$note) {
            throw new \InvalidArgumentException('Note not found.');
        }

        // Supprimer la note de la base de données
        $note->delete();
    }
}
