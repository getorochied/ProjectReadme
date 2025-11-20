# README - Portfolio des projets MiNET

[Gustave Beauvallet](https://github.com/getorochied/ProjectReadme) | **[TODO & Suivi](TODO.md)** | **[Commandes](COMMANDS.md)**

---

## Description

Application Symfony de gestion de portfolios de projets pour l'association MiNET. Permet d'organiser des projets avec leurs tâches, de gérer les contributeurs, et de créer des galeries publiques/privées de projets sélectionnés.

**Statut actuel:** 🎉 PROJET COMPLÉTÉ À 100% - Toutes les phases terminées (19/19 items obligatoires)

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
| `/login` | **Connexion** (olivier@localhost / 123456) |
| `/logout` | **Déconnexion** (redirige vers /portfolio) |
| `/showcase/public` | **Showcases publiques uniquement** (accès libre) |
| `/showcase` | Liste showcases (publiques si non connecté, toutes si connecté) |
| `/showcase/new` | **Création showcase** 🔒 (authentification requise) |
| `/showcase/{id}` | Détail showcase (privées = login requis) |
| `/portfolio` | Liste de tous les portfolios |
| `/portfolio/{id}` | Détail d'un portfolio (projets + tâches) |
| `/portfolio/{id}/project/new` | **Création projet** 🔒 (authentification requise) |
| `/project` | Liste de tous les projets (avec images) |
| `/project/{id}` | Détail d'un projet avec membres, tâches et image |
| `/project/{id}/edit` | **Édition projet** 🔒 (authentification requise) |
| `/user` | Liste des utilisateurs |
| `/user/{id}` | Profil utilisateur avec portfolio personnel |

---

## Données de test

**3 utilisateurs** : olivier, gustave, alice (password: `123456`)  
**3 portfolios** : 1 par utilisateur (relation 1:1)  
**4 projets** : Logs, Docker, MAJ MiNET, API REST  
**11 tâches** : Réparties dans les projets  
**3 showcases** : Galeries Infrastructure, Dev Web, Projets Alice

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
| **Phase 1** - Modèle & consultation | ✅ 100% | 11/11 |
| **Phase 2** - CRUD & contextualisation | ✅ 100% | 5/5 |
| **Phase 3** - Auth & médias | ✅ 100% | 3/3 |
| **Bonus** - Améliorations | 0% | 0/6 |

**Total:** 🎉 19/19 items OBLIGATOIRES (100% COMPLÉTÉ)

### Phase 1 complétée
- Toutes les entités créées avec nomenclature correcte
- Relations OneToOne, OneToMany, ManyToMany implémentées
- Base de données avec contraintes d'intégrité
- Fixtures générant données cohérentes
- Pages de consultation avec Bootstrap
- Navigation fluide entre entités

### Phase 2 COMPLÉTÉE ✅
✅ **#12 - ShowcaseController CRUD complet** 
- Routes: /showcase, /showcase/new, /showcase/{id}, /showcase/{id}/edit
- Formulaire ShowcaseType avec validation
- Templates Bootstrap modernes
- Affichage des projets associés

✅ **#13 - ProjectController CRUD complet**
- Routes: /project, /portfolio/{id}/project/new, /project/{id}, /project/{id}/edit
- Formulaire ProjectType avec 8 champs (dates, statut, membres, showcases)
- Templates avec grille de cartes et badges de statut
- Affichage détaillé des membres et tâches

✅ **#14 - Consultation publique des showcases et projets**
- Route /showcase/public pour showcases publiques uniquement
- Méthode findPublicShowcases() dans le repository
- Navigation complète: Showcases publiques → Showcase → Projets
- Liens cliquables vers les projets depuis les showcases
- Badge "Public" pour identifier les showcases accessibles

✅ **#15 - Affichage portfolio par User**
- Page /user/{id} affiche le portfolio personnel de l'utilisateur
- Section "Portfolio Personnel" avec statistiques (nombre de projets)
- Lien "Voir le portfolio complet" vers la page dédiée
- Navigation bidirectionnelle User ↔ Portfolio

✅ **#16 - Contextualisation création Project**
- Route /portfolio/{id}/project/new (au lieu de /project/new)
- Auto-liaison du projet au portfolio
- Champ portfolio désactivé dans le formulaire (pré-rempli)
- Bouton "Nouveau projet" déplacé dans la page du portfolio
- Redirections edit/delete vers le portfolio parent

### Phase 3 COMPLÉTÉE ✅

✅ **#17 - Upload d'images pour Projects**
- VichUploaderBundle 2.8.1 installé et configuré
- Propriétés ajoutées: imageFile, imageName, imageSize, updatedAt
- SmartUniqueNamer pour noms de fichiers uniques
- Formulaire avec VichImageType (preview, delete, download)
- Affichage dans templates (index: vignettes, show: grande image)
- Upload destination: public/uploads/projects/

✅ **#18 - Système d'authentification Symfony**
- Généré avec `symfony console make:auth`
- LoginFormAuthenticator avec redirection vers portfolio
- SecurityController (login/logout)
- security.yaml configuré (User provider, logout target)
- Template login.html.twig avec Bootstrap moderne
- Routes CRUD protégées avec #[IsGranted('ROLE_USER')]
- Navbar dynamique: affiche username + déconnexion si connecté
- Comptes test: olivier@localhost / 123456

✅ **#19 - Filtrage showcases selon authentification**
- ShowcaseController::index() filtre selon statut connexion
- Utilisateur connecté: voir toutes les showcases
- Utilisateur anonyme: voir uniquement les publiques
- ShowcaseController::show() protège accès aux privées
- Redirection login pour showcases privées si non connecté

---

## Authentification et sécurité

### Comptes de test
```
Email: olivier@localhost | Password: 123456
Email: gustave@localhost | Password: 123456
Email: alice@localhost   | Password: 123456
```

### Routes protégées (requièrent connexion)
- ✅ Création de projet: `/portfolio/{id}/project/new`
- ✅ Édition de projet: `/project/{id}/edit`
- ✅ Suppression de projet
- ✅ Création de showcase: `/showcase/new`
- ✅ Édition de showcase: `/showcase/{id}/edit`
- ✅ Suppression de showcase

### Routes publiques (accès libre)
- ✅ Liste portfolios, projets, showcases publiques
- ✅ Détails des entités publiques
- ✅ Page de connexion

### Filtrage des showcases
- **Anonyme:** Voit uniquement les 2 showcases publiques
- **Connecté:** Voit toutes les 3 showcases (publiques + privées)
- **Accès direct showcase privée:** Redirection vers login si non connecté

---

## Fonctionnalités bonus disponibles (optionnel)

Les 6 items de la Phase 4 (bonus) peuvent être implémentés pour améliorer l'application:
1. Contextualisation création Showcase par User
2. Ajout de Project à Showcase depuis la page du projet
3. Messages flash pour opérations CRUD
4. Système de marque-pages/panier
5. Voters pour permissions propriétaires
6. Dashboard personnalisé par utilisateur

---

### Prochaines étapes (optionnel)
1. **Upload d'images pour Projects** - VichUploaderBundle ou gestion manuelle (#17)
2. **Authentification Symfony** - make:auth, security.yaml (#18)
3. **Filtrage showcases publiques** - Restriction selon authentification (#19)

Ces étapes sont maintenant COMPLÉTÉES, tous les items obligatoires sont implémentés!

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

## Conventions

- **Classes:** PascalCase (User, Portfolio, Project)
- **Méthodes:** camelCase (getProjects, addMember)
- **Routes:** snake_case (app_portfolio_show)
- **Templates:** kebab-case (portfolio/index.html.twig)

---

**Dernière mise à jour:** 20 novembre 2025  
**Version:** 3.0 - 🎉 PROJET COMPLÉTÉ À 100% (19/19 items obligatoires)  
**Auteur:** Gustave Beauvallet