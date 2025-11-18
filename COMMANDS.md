# Commandes Symfony - Référence complète

Ce fichier contient toutes les commandes utiles pour le développement du projet.

---

## Serveur de développement

```bash
# Démarrer avec Symfony CLI (recommandé)
symfony serve

# Démarrer avec PHP natif
php -S localhost:8000 -t public/

# Arrêter le serveur Symfony
symfony server:stop

# Voir les logs du serveur
symfony server:log
```

---

## Base de données

### Gestion de la base

```bash
# Créer la base de données
php bin/console doctrine:database:create

# Supprimer la base de données
php bin/console doctrine:database:drop --force

# Recréer complètement la base
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:schema:create
```

### Schéma et migrations

```bash
# Mettre à jour le schéma (après modification d'entités)
php bin/console doctrine:schema:update --force

# Voir les changements SQL sans les appliquer
php bin/console doctrine:schema:update --dump-sql

# Créer le schéma depuis zéro
php bin/console doctrine:schema:create

# Valider le mapping des entités
php bin/console doctrine:schema:validate
```

### Fixtures (données de test)

```bash
# Charger les fixtures (avec confirmation)
php bin/console doctrine:fixtures:load

# Charger sans confirmation
php bin/console doctrine:fixtures:load --no-interaction

# Charger en mode append (sans purger)
php bin/console doctrine:fixtures:load --append
```

---

## Requêtes SQL directes

### Informations sur les tables

```bash
# Lister toutes les tables
php bin/console dbal:run-sql "SELECT name FROM sqlite_master WHERE type='table' ORDER BY name"

# Voir la structure d'une table
php bin/console dbal:run-sql "PRAGMA table_info(user)"
php bin/console dbal:run-sql "PRAGMA table_info(portfolio)"
php bin/console dbal:run-sql "PRAGMA table_info(project)"

# Voir les index d'une table
php bin/console dbal:run-sql "PRAGMA index_list(user)"

# Voir les détails d'un index
php bin/console dbal:run-sql "PRAGMA index_info(UNIQ_8D93D649B96B5643)"
```

### Compter les enregistrements

```bash
# Compter les utilisateurs
php bin/console dbal:run-sql "SELECT COUNT(*) as total FROM user"

# Compter les portfolios
php bin/console dbal:run-sql "SELECT COUNT(*) as total FROM portfolio"

# Compter les projets
php bin/console dbal:run-sql "SELECT COUNT(*) as total FROM project"

# Compter les tâches
php bin/console dbal:run-sql "SELECT COUNT(*) as total FROM task"

# Compter les showcases
php bin/console dbal:run-sql "SELECT COUNT(*) as total FROM showcase"
```

### Requêtes de lecture

```bash
# Lister tous les utilisateurs
php bin/console dbal:run-sql "SELECT * FROM user"

# Lister les portfolios avec leurs propriétaires
php bin/console dbal:run-sql "SELECT u.id, u.username, u.portfolio_id, p.description FROM user u JOIN portfolio p ON u.portfolio_id = p.id"

# Compter les projets par portfolio
php bin/console dbal:run-sql "SELECT p.id, p.description, COUNT(pr.id) as nb_projects FROM portfolio p LEFT JOIN project pr ON pr.portfolio_id = p.id GROUP BY p.id"

# Lister les projets avec leurs membres
php bin/console dbal:run-sql "SELECT p.title, u.username FROM project p JOIN project_user pu ON p.id = pu.project_id JOIN user u ON u.id = pu.user_id"

# Voir les projets en cours
php bin/console dbal:run-sql "SELECT * FROM project WHERE status='in_progress'"

# Voir les relations project_user
php bin/console dbal:run-sql "SELECT * FROM project_user"

# Voir les relations showcase_project
php bin/console dbal:run-sql "SELECT * FROM showcase_project"
```

### Vérifications spécifiques

```bash
# Vérifier la contrainte OneToOne User↔Portfolio
php bin/console dbal:run-sql "SELECT u.id, u.username, u.portfolio_id FROM user u ORDER BY u.id"

# Vérifier que chaque portfolio a un propriétaire
php bin/console dbal:run-sql "SELECT p.id, p.description, u.username as owner FROM portfolio p JOIN user u ON u.portfolio_id = p.id"

# Compter les tâches complétées vs non complétées
php bin/console dbal:run-sql "SELECT completed, COUNT(*) as count FROM task GROUP BY completed"

# Lister les showcases publiques
php bin/console dbal:run-sql "SELECT * FROM showcase WHERE is_public = 1"
```

---

## Debug et développement

### Routes

```bash
# Lister toutes les routes
php bin/console debug:router

# Chercher une route spécifique
php bin/console debug:router app_portfolio

# Voir les détails d'une route
php bin/console debug:router app_portfolio_show

# Format JSON
php bin/console debug:router --format=json
```

### Entités et mapping

```bash
# Lister toutes les entités
php bin/console doctrine:mapping:info

# Voir le mapping d'une entité
php bin/console doctrine:mapping:describe User
php bin/console doctrine:mapping:describe Portfolio

# Générer les getters/setters manquants
php bin/console make:entity --regenerate
```

### Services et conteneur

```bash
# Lister tous les services
php bin/console debug:container

# Chercher un service
php bin/console debug:container doctrine

# Voir les détails d'un service
php bin/console debug:container doctrine.orm.entity_manager

# Lister les services publics
php bin/console debug:container --show-public
```

### Configuration

```bash
# Voir toute la configuration
php bin/console debug:config

# Configuration d'un bundle spécifique
php bin/console debug:config doctrine
php bin/console debug:config framework

# Voir les paramètres
php bin/console debug:container --parameters
```

### Cache

```bash
# Vider tout le cache
php bin/console cache:clear

# Cache de production
php bin/console cache:clear --env=prod

# Réchauffer le cache
php bin/console cache:warmup

# Vider uniquement le cache Doctrine
php bin/console doctrine:cache:clear-metadata
php bin/console doctrine:cache:clear-query
php bin/console doctrine:cache:clear-result
```

---

## Générateurs Symfony (make)

### Contrôleurs

```bash
# Générer un contrôleur simple
php bin/console make:controller

# Générer un CRUD complet
php bin/console make:crud Showcase
php bin/console make:crud Project
```

### Entités

```bash
# Créer une nouvelle entité
php bin/console make:entity

# Ajouter des champs à une entité existante
php bin/console make:entity User

# Régénérer les getters/setters
php bin/console make:entity --regenerate
```

### Formulaires

```bash
# Créer un formulaire
php bin/console make:form

# Type de formulaire pour une entité
php bin/console make:form ProjectType Project
```

### Authentification

```bash
# Générer le système d'authentification
php bin/console make:auth

# Créer un système de registration
php bin/console make:registration-form

# Reset password
php bin/console make:reset-password
```

### Tests

```bash
# Créer un test unitaire
php bin/console make:test

# Créer un test fonctionnel
php bin/console make:functional-test

# Lancer les tests
php bin/phpunit
```

---

## Composer

```bash
# Installer les dépendances
composer install

# Mettre à jour les dépendances
composer update

# Ajouter un package
composer require symfony/mailer

# Ajouter un package de dev
composer require --dev symfony/debug-bundle

# Retirer un package
composer remove package-name

# Vérifier les packages obsolètes
composer outdated

# Valider composer.json
composer validate
```

---

## Git

```bash
# Statut du dépôt
git status

# Ajouter des fichiers
git add .
git add README.md TODO.md

# Commit
git commit -m "Description des changements"

# Voir l'historique
git log --oneline --graph --all

# Voir les différences
git diff
git diff README.md

# Branches
git branch
git checkout -b nouvelle-branche
git merge autre-branche

# Push vers GitHub
git push origin main
```

---

## Sécurité

```bash
# Hasher un mot de passe
php bin/console security:hash-password

# Vérifier les vulnérabilités
composer audit

# Mettre à jour les packages de sécurité
composer update --with-dependencies
```

---

## Statistiques et analyse

```bash
# Compter les lignes de code
find src -name '*.php' | xargs wc -l

# Compter les fichiers
find src -name '*.php' | wc -l

# Voir la taille de la base de données
du -h var/data.db

# Analyser la structure du projet
tree -L 2 src/
```

---

## Tests HTTP (curl)

```bash
# Tester la page d'accueil
curl http://localhost:8000/

# Tester avec headers complets
curl -I http://localhost:8000/portfolio

# Tester les routes
curl http://localhost:8000/portfolio
curl http://localhost:8000/user
curl http://localhost:8000/portfolio/1

# Suivre les redirections
curl -L http://localhost:8000/

# Voir uniquement les headers
curl -I http://localhost:8000/portfolio
```

---

## Assets et Frontend

```bash
# Vider le cache d'assets
php bin/console cache:clear

# Lister les assets
php bin/console debug:config framework assets

# Installer les assets dans public/
php bin/console assets:install
```

---

## Logs

```bash
# Voir les logs en temps réel
tail -f var/log/dev.log

# Voir les dernières lignes
tail -n 50 var/log/dev.log

# Chercher dans les logs
grep "ERROR" var/log/dev.log

# Vider les logs
> var/log/dev.log
```

---

## Maintenance

```bash
# Vérifier les permissions
ls -la var/cache
ls -la var/log

# Corriger les permissions (Linux/Mac)
chmod -R 777 var/cache var/log

# Nettoyer complètement le projet
rm -rf var/cache/* var/log/*
php bin/console cache:clear
```

---

**Dernière mise à jour:** 18 novembre 2025  
**Version:** 1.0
