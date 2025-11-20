# README - Portfolio des projets MiNET

[Gustave Beauvallet](https://github.com/getorochied/ProjectReadme) | **[TODO & Suivi](TODO.md)** | **[Commandes](COMMANDS.md)**

---

## Description

Application Symfony de gestion de portfolios de projets pour l'association MiNET. Permet d'organiser des projets avec leurs tâches, de gérer les contributeurs, et de créer des galeries publiques/privées de projets sélectionnés.

---

## Architecture

### Entités principales
- **User** : Membre avec authentification (username, email, password, roles)
- **Portfolio** : Collection de projets d'un utilisateur (relation 1:1 avec User)
- **Project** : Projet avec titre, description, statut, dates et tâches
- **Task** : Tâche de checklist (title, completed, position)
- **Showcase** : Galerie publique/privée de projets sélectionnés

### Relations clés
- **User (1) ↔ (1) Portfolio** - Chaque utilisateur a UN portfolio personnel
- **User (1) → (N) Showcase** - Un utilisateur peut créer plusieurs showcases
- **Portfolio (1) → (N) Project** - Un portfolio contient plusieurs projets
- **Project (N) ↔ (N) User** - Gestion des contributeurs
- **Project (1) → (N) Task** - Checklist de tâches par projet
- **Showcase (N) ↔ (N) Project** - Sélection de projets pour galeries

### Technologies
- **Framework:** Symfony 7.1 LTS
- **PHP:** 8.2+
- **Base de données:** SQLite 3 avec Doctrine ORM
- **Frontend:** Bootstrap 5.2.3 (Freelancer theme) + Font Awesome 6.3.0
- **Templates:** Twig 3.x
- **Upload:** VichUploaderBundle 2.8.1
- **Authentification:** Symfony Security Component

---

## Routes disponibles

| URL | Description |
|-----|-------------|
| `/` | Redirection automatique vers `/portfolio` |
| `/login` | **Connexion** (orchidium@minet.net / 123456) |
| `/logout` | **Déconnexion** (redirige vers /portfolio) |
| `/dashboard` | **Dashboard personnalisé** - Statistiques et actions rapides (authentification requise) |
| `/portfolio` | Liste de tous les portfolios |
| `/portfolio/{id}` | Détail d'un portfolio avec ses projets |
| `/portfolio/{id}/project/new` | **Création projet** (authentification requise) |
| `/project` | Liste de tous les projets (avec images) |
| `/project/{id}` | Détail d'un projet (membres, tâches, image) |
| `/project/{id}/edit` | **Édition projet** (authentification requise) |
| `/project/{projectId}/add-to-showcase/{showcaseId}` | **Ajout projet à showcase** (authentification requise) |
| `/showcase` | Liste showcases (publiques si anonyme, toutes si connecté) |
| `/showcase/new` | **Création showcase** (authentification requise) |
| `/showcase/{id}` | Détail showcase (privées = redirection login si anonyme) |
| `/showcase/{id}/edit` | **Édition showcase** (authentification requise) |
| `/user` | Liste des utilisateurs |
| `/user/{id}` | Profil utilisateur avec portfolio personnel |
| `/user/{id}/showcase/new` | **Création showcase contextuelle** (authentification requise) |
| `/favorites` | **Page favoris** - Liste des projets favoris (session) |
| `/favorites/toggle/{id}` | **Toggle favori** - Ajouter/retirer projet (POST, CSRF) |
| `/favorites/clear` | **Effacer favoris** - Supprimer tous les favoris (POST, CSRF) |

---

## Données de test

## Données de test

**3 utilisateurs** : orchidium, liteapp, andinoxis (email: `{username}@minet.net`, password: `123456`)  
**3 portfolios** : 1 par utilisateur (relation 1:1)  
**4 projets** : Serveur logs, Migration Docker, MAJ MiNET, API REST  
**11 tâches** : Réparties dans les projets avec statuts  
**3 showcases** : 2 publiques (Orchidium, Liteapp), 1 privée (Andinoxis)

---

## Démarrage rapide

```bash
# Démarrer le serveur
symfony serve
# ou
php -S localhost:8000 -t public/

# Recréer la base de données
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:schema:create

# Charger les fixtures
php bin/console doctrine:fixtures:load --no-interaction

# Accéder à l'application
http://localhost:8000
```

---

## Commandes utiles

### Base de données
```bash
# Mettre à jour le schéma
php bin/console doctrine:schema:update --force

# Voir les changements SQL
php bin/console doctrine:schema:update --dump-sql

# Requêtes directes
php bin/console dbal:run-sql "SELECT * FROM user"
```

### Debug
```bash
# Lister les routes
php bin/console debug:router

# Voir les entités
php bin/console doctrine:mapping:info

# Vider le cache
php bin/console cache:clear
```

---

## Documentation

- **[TODO & Suivi détaillé](TODO.md)** - Phases, tâches, vérifications
- **[Commandes Symfony](COMMANDS.md)** - Référence complète des commandes
- **[Cahier des charges](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/cahier-charges-projet.html)** - Spécifications officielles
- **[Guide de réalisation](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/)** - Instructions détaillées
- **[Checklist officielle](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/checklist-projet.html)** - 25 items à réaliser

---

## Progression

| Phase | Statut | Items |
|-------|--------|-------|
| **Phase 1** - Modèle & consultation | 100% | 11/11 |
| **Phase 2** - CRUD & contextualisation | 100% | 5/5 |
| **Phase 3** - Auth & médias | 100% | 3/3 |
| **Bonus** - Améliorations | 100% | 6/6 |

### Fonctionnalités bonus implémentées
- ✅ #20 - Contextualisation création showcase par user
- ✅ #21 - Ajout contextuel projet à showcase
- ✅ #22 - Messages flash pour opérations CRUD
- ✅ #23 - Système de favoris/marque-pages (session)
- ✅ #24 - Protection Voters (ownership-based)
- ✅ #25 - Dashboard personnalisé avec statistiques


## Authentification et sécurité

### Comptes de test
```
Email: orchidium@minet.net | Password: 123456
Email: liteapp@minet.net   | Password: 123456
Email: andinoxis@minet.net | Password: 123456
```

### Routes protégées (requièrent connexion)
- Création de projet: `/portfolio/{id}/project/new`
- Édition de projet: `/project/{id}/edit`
- Suppression de projet
- Création de showcase: `/showcase/new`
- Édition de showcase: `/showcase/{id}/edit`
- Suppression de showcase

### Routes publiques (accès libre)
- Liste portfolios, projets, showcases publiques
- Détails des entités publiques
- Page de connexion

### Filtrage des showcases
- **Anonyme:** Voit uniquement les 2 showcases publiques via `/showcase`
- **Connecté:** Voit toutes les 3 showcases (publiques + privées) via `/showcase`
- **Accès direct showcase privée:** Redirection vers `/login` si non connecté
- **Note:** La route `/showcase/public` existe toujours mais `/showcase` filtre automatiquement
- **Propriétaires:** Orchidium (publique), Liteapp (publique), Andinoxis (privée)

---

## Structure des fichiers

```
src/
├── Controller/          # PortfolioController, UserController
├── Entity/              # User, Portfolio, Project, Task, Showcase
├── Repository/          # Repositories Doctrine
└── DataFixtures/        # AppFixtures.php

templates/
├── base.html.twig       # Layout avec navbar Bootstrap
├── portfolio/           # Liste et détail des portfolios
└── user/                # Liste et profil des utilisateurs

config/
└── packages/            # Configuration Symfony

var/
└── data.db              # Base SQLite
```

---

**Dernière mise à jour:** 20 novembre 2025  
**Auteur:** Gustave Beauvallet