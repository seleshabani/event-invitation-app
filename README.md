# Guest Event Project

Ce projet est une application full-stack composée d'un backend API Laravel (dans `guest-event-app/`) et d'une interface utilisateur frontend (dans `guest-event-ui/`) utilisant Vite et probablement React.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre système :

- **PHP** (version 8.1 ou supérieure)
- **Composer** (gestionnaire de dépendances PHP)
- **Node.js** (version 16 ou supérieure)
- **npm** (gestionnaire de paquets pour le frontend)
- **MySQL** ou un autre SGBD compatible avec Laravel (pour la base de données)
- **Git** (pour cloner le projet si nécessaire)

## Installation et Configuration

### 1. Cloner le projet (si nécessaire)

Si vous n'avez pas encore cloné le projet, exécutez :

```bash
git clone <url-du-repo>
cd guest-event
```

### 2. Configuration du Backend (Laravel)

1. Accédez au dossier du backend :
   ```bash
   cd guest-event-app
   ```

2. Installez les dépendances PHP :
   ```bash
   composer install
   ```

3. Copiez le fichier d'environnement exemple :
   ```bash
   cp .env.example .env
   ```

4. Configurez le fichier `.env` :
   - Définissez les paramètres de base de données (DB_HOST, DB_DATABASE, etc.)
   - Configurez les paramètres de mail (MAIL_MAILER, MAIL_HOST, etc.) si nécessaire
   - Configurez d'autres variables d'environnement si nécessaire (clé d'application, etc.)

5. Générez la clé d'application :
   ```bash
   php artisan key:generate
   ```

6. Exécutez les migrations pour créer les tables de base de données :
   ```bash
   php artisan migrate
   ```

7. Installez Laravel Passport pour l'authentification OAuth :
   ```bash
   php artisan passport:install
   ```
   Cela créera les clients OAuth nécessaires (client_id et client_secret).

8. (Optionnel) Exécutez les seeders pour ajouter des données de test :
   ```bash
   php artisan db:seed
   ```

### 3. Configuration du Frontend

1. Accédez au dossier du frontend :
   ```bash
   cd ../guest-event-ui
   ```

2. Installez les dépendances Node.js :
   ```bash
   npm install
   ```

## Exécution du Projet

### Démarrer le Backend

Dans le dossier `guest-event-app` :
```bash
php artisan serve
```

Le serveur backend sera accessible sur `http://localhost:8000` par défaut.

### Démarrer le Frontend

Dans le dossier `guest-event-ui` :
```bash
npm run dev
```

Le serveur de développement frontend sera accessible sur `http://localhost:5173` par défaut (ou l'URL indiquée dans la console).

## Utilisation

- Ouvrez votre navigateur et accédez à l'URL du frontend (par exemple `http://localhost:5173`).
- L'interface utilisateur communiquera avec l'API backend pour gérer les événements et les invités.

## Exécution des Jobs et Files d'Attente

Pour traiter les jobs en arrière-plan, tels que l'envoi d'emails d'invitation et l'importation des invités :

```bash
php artisan queue:work
```

Cela démarrera le worker de file d'attente. Pour le développement, vous pouvez utiliser `php artisan queue:listen` à la place.

Assurez-vous que votre configuration de file d'attente (.env QUEUE_CONNECTION) est correcte.

Pour un déploiement en production :
- Configurez un serveur web (Apache/Nginx) pour servir le backend Laravel.
- Construisez le frontend pour la production :
  ```bash
  cd guest-event-ui
  npm run build
  ```
- Déployez les fichiers générés dans `dist/` sur votre serveur.

## Structure du Projet

- `guest-event-app/` : Backend API Laravel
- `guest-event-ui/` : Interface utilisateur frontend

## Support

Si vous rencontrez des problèmes, vérifiez les logs dans `guest-event-app/storage/logs/` pour le backend et la console du navigateur pour le frontend.