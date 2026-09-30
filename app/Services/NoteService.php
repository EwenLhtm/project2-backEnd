<?php

namespace App\Services;

use App\Models\Note;

class NoteService
{
    /**
     * Créer une nouvelle note.
     */
    public function create(array $data)
    {
        // Créez la note en utilisant le modèle Note
        $newNote = Note::create([
            'user_id' => $data['user_id'],
            'tag_id' => $data['tag_id'],
            'text' => $data['text'],
        ]);

        // Ajoutez la nouvelle note à la bdd
        session()->flash('message', 'Note added!');

        return response()->json($newNote, 201);
    }

    /**
     * Récupérer toutes les notes.
     */
    public function getAll()
    {
        // Récupérer toutes les notes depuis la base de données
        return response()->json(Note::all());
    }

    /**
     * Récupérer une note spécifique par son ID.
     * 
     */
    public function getOneById(Int $id)
    {
        // Récupérer une note spécifique par son ID depuis la base de données
        return response()->json(Note::find($id));
    }

    /**
     * mettre à jour une note spécifique par son ID.
     * 
     */
    public function update(Int $id, $data)
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

        // Ajouter un message flash pour indiquer que la mise à jour a réussi
        session()->flash('message', 'Note updated!');

        return response()->json(['message' => 'Note updated successfully.']);
    }

    /**
     * Supprimer une note spécifique par son ID.
     */
    public function delete(Int $id)
    {
        // Vérifier que la note existe
        $note = Note::find($id);
        if (!$note) {
            throw new \InvalidArgumentException('Note not found.');
        }

        // Supprimer la note de la base de données
        $note->delete();

        // Ajouter un message flash pour indiquer que la suppression a réussi
        session()->flash('message', 'Note deleted!');

        return response()->json(['message' => 'Note deleted successfully.']);
    }
}
