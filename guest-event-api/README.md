# Guest Event App

_Application Laravel de gestion d\'événements et d\'invitation de participants._

Ce dépôt contient une API RESTful développée avec Laravel 10, Passport et L5‑Swagger pour permettre à un utilisateur de créer des événements et d\'uploader des listes d\'invités au format CSV/Excel. Les invités reçoivent ensuite un mail d\'invitation via un job asynchrone.

---

## 🧱 Structure du projet

Le projet suit une architecture **Domain‑Service‑Repository** claire :

- `app/Models` : Eloquent models (`User`, `Event`, `Guest`).
- `app/Repositories` : couche d\'accès aux données, encapsule les requêtes Eloquent.
- `app/Services` : logique métier (authentification, création d\'événements, traitement des invités).
- `app/Http/Controllers` : contrôleurs d\'API exposant les routes.
- `app/Http/Requests` : classes de validation pour les entrées HTTP.
- `app/Http/Resources` : transformation des ressources pour les réponses JSON.
- `app/Jobs` : `GuestProcessJob` gère le parsing du fichier d\'invités et l\'envoi des mails.
- `app/Mail` : mailable pour les invitations (`EventInvitationMail`).
- Documentation OpenAPI via annotations (`OpenApi\Annotations`).

Les migrations et factories se trouvent sous `database/`.

---

## 🚀 Installation & configuration

1. **Pré‑requis** : PHP ≥ 8.1, Composer, MySQL (ou autre base compatible), Node.js (pour Vite).
2. Cloner le dépôt :
   ```bash
   git clone <repo> guest-event-app
   cd guest-event-app
   ```
3. Installer les dépendances PHP :
   ```bash
   composer install
   ```
4. Copier et configurer l\'environnement :
   ```bash
   cp .env.example .env
   # ajuster DB_* et MAIL_*
   ```
5. Générer la clé d\'application et migrer la base :
   ```bash
   php artisan key:generate
   php artisan migrate
   ```
6. Installer Passport pour l\'API et générer les clés :
   ```bash
   php artisan passport:install
   ```
7. (Optionnel) Lier le dossier de stockage :
   ```bash
   php artisan storage:link
   ```
8. Démarrer le serveur de développement :
   ```bash
   php artisan serve
   ```

> Le front n\'est pas fourni, l\'application expose uniquement une API.

---

## 📦 Modèles et relations

| Modèle | Champs principaux | Relations |
|--------|-------------------|-----------|
| **User** | `name`, `email`, `password` | hasMany **Event** |
| **Event** | `title`, `description`, `location`, `start_time`, `end_time`, `user_id` | belongsTo **User**, hasMany **Guest** |
| **Guest** | `name`, `email`, `event_id`, `is_invitation_send` | belongsTo **Event** |

---

## 🔐 Authentification

L\'API utilise **Laravel Passport** pour l\'authentification par token OAuth2. Un utilisateur peut s\'inscrire via `/api/register`, puis utiliser son `access_token` dans l\'en‑tête `Authorization: Bearer <token>` pour accéder aux routes protégées.

---

## 🧭 Endpoints disponibles

### Public
| Méthode | Chemin | Description |
|---------|--------|-------------|
| GET | `/api/` | Message de bienvenue |
| POST | `/api/register` | Création d\'un utilisateur (`name`, `email`, `password`, `password_confirmation`) |

### Protégés (auth:api)
| Méthode | Chemin | Payload attendu | Description |
|---------|--------|-----------------|-------------|
| GET | `/api/user` | — | Récupère l\'utilisateur authentifié |
| GET | `/api/events` | — | Liste paginée des événements de l\'utilisateur |
| POST | `/api/events` | `title`, `description?`, `location?`, `start_time`, `end_time?` | Crée un événement |
| POST | `/api/guests/upload` | `event_id`, `file` (csv/xls/xlsx, max 2Mo) | Upload d\'un fichier d\'invités |

Les routes `events` sont définies via `Route::apiResource` – GET/POST/PUT/DELETE standards, mais seules `index` et `store` sont implémentées actuellement.

> Les schémas de requête/response sont documentés via Swagger : générez la doc en exécutant `php artisan l5-swagger:generate` et consultez `/api/documentation`.

---

## 📁 Traitement des invités

1. Le fichier est stocké dans `storage/app/private/guests`.
2. Un job `GuestProcessJob` est dispatché ; il lit chaque ligne du tableur et enregistre les invités via `GuestRepository`.
3. Un mail `EventInvitationMail` est envoyé à chaque adresse valide.
4. Le fichier est supprimé après traitement.

Formats supportés : CSV, XLS, XLSX. Les deux premières colonnes doivent contenir le **nom** puis l\'**e-mail**.

---

## 🧪 Tests

Des tests d\'exemple sont fournis (`tests/Feature/ExampleTest.php`), mais aucune couverture métier n\'est encore implémentée. Utilisez PHPUnit :

```bash
./vendor/bin/phpunit
```

---

## 🛠️ Développement

- Les services et les repos sont injectés via le conteneur (type‑hint dans le constructeur).
- Les responsabilités sont séparées : le contrôleur délègue au service, le service appelle le repo.
- Les requêtes sont validées avec `FormRequest`.
- La documentation API est générée automatiquement grâce aux annotations OpenAPI.

---

## 📬 Envoi de mails

La configuration `MAIL_*` dans `.env` (SMTP, Mailgun, etc.) est requise pour l\'envoi des invitations.

---

## 📝 Remarques finales

Cette API est conçue comme une base pour un système d\'événementiel simple. Elle peut être étendue avec :
- gestion des invités (list, update, delete),
- ajout de webhooks ou notifications, 
- interface front‑end.

Pour toute question ou amélioration, consultez l\'historique Git ou ouvrez une issue.

---

#### © 2026 Guest Event App
