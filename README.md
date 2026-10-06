# API Notes

Documentation rapide de l'API Laravel du projet.

## Démarrage

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Par défaut, l'API est accessible à l'adresse `http://localhost:8000/api`.

Toutes les réponses sont au format JSON. Les routes protégées nécessitent un
token Sanctum dans l'en-tête :

```http
Authorization: Bearer <token>
Accept: application/json
```

## Endpoints

### Authentification

| Méthode | Endpoint | Authentification | Description |
| --- | --- | --- | --- |
| `POST` | `/register` | Non | Créer un compte |
| `POST` | `/login` | Non | Se connecter et obtenir un token |
| `POST` | `/logout` | Oui | Se déconnecter |

#### Inscription

`POST /api/register`

```json
{
  "name": "Alice",
  "email": "alice@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

#### Connexion

`POST /api/login`

```json
{
  "email": "alice@example.com",
  "password": "password123"
}
```

La réponse contient un champ `token` à réutiliser pour les endpoints protégés.

### Notes

Toutes les routes ci-dessous nécessitent une authentification.

| Méthode | Endpoint | Description |
| --- | --- | --- |
| `POST` | `/notes` | Créer une note |
| `GET` | `/notes` | Lister les notes |
| `GET` | `/notes/{id}` | Récupérer une note |
| `PUT` | `/notes/{id}` | Modifier une note |
| `DELETE` | `/notes/{id}` | Supprimer une note |

Corps attendu pour `POST /api/notes` et `PUT /api/notes/{id}` :

```json
{
  "user_id": 1,
  "tag_id": 1,
  "text": "Contenu de la note"
}
```

### Tags

Toutes les routes ci-dessous nécessitent une authentification.

| Méthode | Endpoint | Description |
| --- | --- | --- |
| `POST` | `/tags` | Créer un tag |
| `GET` | `/tags` | Lister les tags |
| `GET` | `/tags/{id}` | Récupérer un tag |
| `PUT` | `/tags/{id}` | Modifier un tag |
| `DELETE` | `/tags/{id}` | Supprimer un tag |

Corps attendu pour `POST /api/tags` et `PUT /api/tags/{id}` :

```json
{
  "name": "Travail"
}
```

## Validation

- Un utilisateur doit fournir un nom, un email valide et un mot de passe d'au
  moins 8 caractères confirmé.
- Le champ `text` d'une note est limité à 255 caractères.
- `user_id` et `tag_id` doivent correspondre à des ressources existantes.
- Le nom d'un tag est obligatoire, unique et limité à 50 caractères.

## Route web

| Méthode | Endpoint | Description |
| --- | --- | --- |
| `GET` | `/` | Affiche la page d'accueil Laravel |
