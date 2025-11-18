# README - Portfolio des projets MiNET

[Gustave Beauvallet](https://github.com/getorochied/ProjectReadme) | **[TODO & Suivi](TODO.md)** | **[Commandes](COMMANDS.md)**

---

## Description

Application Symfony de gestion de portfolios de projets pour l'association MiNET. Permet d'organiser des projets avec leurs tâches, de gérer les contributeurs, et de créer des galeries publiques/privées de projets sélectionnés.

**Statut actuel:** Phase 1 COMPLÈTE (11/11) - 57.9% du projet total

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

---

## Routes disponibles

| URL | Description |
|-----|-------------|
| `/` | Redirection automatique vers `/portfolio` |
| `/portfolio` | Liste de tous les portfolios |
| `/portfolio/{id}` | Détail d'un portfolio (projets + tâches) |
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
| **Phase 1** - Modèle & consultation | 100% | 11/11 |
| **Phase 2** - CRUD & contextualisation | 0% | 0/5 |
| **Phase 3** - Auth & médias | 0% | 0/3 |
| **Bonus** - Améliorations | 0% | 0/6 |

**Total:** 11/19 items OBLIGATOIRES (57.9%)

### Phase 1 complétée
- Toutes les entités créées avec nomenclature correcte
- Relations OneToOne, OneToMany, ManyToMany implémentées
- Base de données avec contraintes d'intégrité
- Fixtures générant données cohérentes
- Pages de consultation avec Bootstrap
- Navigation fluide entre entités

### Prochaines étapes (Phase 2)
1. **ShowcaseController CRUD** - `make:crud Showcase`
2. **ProjectController CRUD** - Ajout new/edit/delete
3. **Navigation Showcase → Projects** - Routes publiques
4. **Contextualisation** - Création selon Portfolio/User

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

**Dernière mise à jour:** 18 novembre 2025  
**Version:** 1.2 - README simplifié, TODO séparé  
**Auteur:** Gustave Beauvallet

**Dernière mise à jour:** 18 novembre 2025  
**Version:** 1.2 - README simplifié, TODO séparé  
**Auteur:** Gustave Beauvallet