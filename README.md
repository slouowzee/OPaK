# OPaK

Un mini réseau social développé avec **Laravel** (PHP) et **Alpine.js**. Simple, efficace.

## Prérequis

- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (ou autre BDD supportée par Laravel)

## Installation

1. **Cloner le projet**
   ```bash
   git clone <url-du-repo>
   cd OPaK
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   npm install
   ```

3. **Configurer l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Préparer la base de données**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

## Lancer le projet

Lance le serveur de dev Laravel et la compilation des assets (Vite) :

```bash
composer run dev
```

L'application sera accessible sur `http://127.0.0.1:8000`.

## Fonctionnalités principales

- **Fil d'actualité** : Posts de tous les utilisateurs ou seulement des abonnements.
- **Messages** : Créer, aimer et répondre aux messages.
- **Social** : Suivre d'autres utilisateurs.
- **Profil** : Gestion de profil, avatar, mur personnel.
- **Notifications** : Alertes sur les interactions.
