# TODO - Suivi du développement

**Progression globale:** 19/19 items OBLIGATOIRES complétés (100%)

---

## Phase 1 - Modèle de données et consultation (11/11 - 100%)

- [x] **#1** Prise de connaissance du cahier des charges (OBLIGATOIRE)
- [x] **#2** Initialisation du projet Symfony 7 LTS avec SQLite (OBLIGATOIRE)
- [x] **#3** Gestion du code source avec Git (RECOMMANDÉ)
- [x] **#4** Entités Portfolio et Project avec association 1-N (OBLIGATOIRE)
- [x] **#5** DataFixtures pour données de test (OBLIGATOIRE)
- [x] **#6** Pages front-office de consultation (OBLIGATOIRE)
  - Liste de tous les portfolios
  - Consultation d'une fiche de portfolio
- [x] **#7** Gabarits Twig pour la présentation (OBLIGATOIRE)
  - Consultation Projects et Tasks
  - Navigation entre entités
- [x] **#8** Intégration Bootstrap 5 (Start Bootstrap Freelancer) (OBLIGATOIRE)
- [x] **#9** Entité User avec relation Many-to-Many vers Project (OBLIGATOIRE)
- [x] **#10** Menus de navigation Bootstrap (OBLIGATOIRE)
- [x] **#11** Entité Showcase avec association M-N vers Project (OBLIGATOIRE) 

---

## Phase 2 - CRUD et contextualisation (5/5 - 100%)

- [x] **#12** Contrôleur CRUD complet pour Showcase (OBLIGATOIRE)
- [x] **#13** Fonctions CRUD pour Project (OBLIGATOIRE)
- [x] **#14** Consultation des Projects depuis les Showcases publiques (OBLIGATOIRE)
- [x] **#15** Liste des portfolios d'un User spécifique (OBLIGATOIRE)
- [x] **#16** Contextualisation création Project selon Portfolio (OBLIGATOIRE)

---

## Phase 3 - Authentification et médias (3/3 - 100%)

- [x] **#17** Upload d'images pour les Projects (OBLIGATOIRE)
- [x] **#18** Système d'authentification Symfony (OBLIGATOIRE)
- [x] **#19** Filtrage: afficher uniquement les showcases publiques (OBLIGATOIRE)

---

## Optionnel - Améliorations (6/6 - BONUS 100%)

- [x] **#20** Contextualisation création Showcase par User
- [x] **#21** Contextualisation ajout Project à Showcase
- [x] **#22** Messages flash pour les opérations CRUD
- [x] **#23** Système de marque-pages/panier dans le front-office
- [x] **#24** Protection d'accès aux données (propriétaires uniquement)
- [x] **#25** Chargement contextuel selon utilisateur connecté


---

## Vérification de conformité avec le cahier des charges

### Section 5.2.1 - Entités requises (nomenclature obligatoire)
- **User** (membre) - `src/Entity/User.php` 
  - Implémente `UserInterface` et `PasswordAuthenticatedUserInterface`
  - Propriétés: `username`, `email`, `password`, `roles`
- **Portfolio** (inventaire) - `src/Entity/Portfolio.php`
  - Propriétés: `description`, `projects` (Collection)
- **Project** (projet) - `src/Entity/Project.php`
  - Propriétés: `title`, `description`, `status`, `startDate`, `endDate`
  - Collections: `tasks`, `members`, `showcases`
- **Task** (tâche) - `src/Entity/Task.php`
  - Propriétés: `title`, `description`, `completed`, `position`

### Section 5.2.2 - Relations obligatoires
- **OneToMany** : Portfolio (1) → (N) Project
  - Implémentation: `Portfolio::$projects` avec `orphanRemoval: true`
- **ManyToMany** : Project (N) ↔ (N) User  
  - Implémentation: `Project::$members` ↔ `User::$projects`
  - Table de jointure: `project_user`
- **OneToOne** : User (1) ↔ (1) Portfolio **CRITIQUE**
  - Implémentation: `User::$portfolio` avec `cascade: ['persist', 'remove']`
  - Contrainte base de données: UNIQUE INDEX sur `user.portfolio_id`

### Section 5.2.3 - Galeries (Showcase)
- **Entité Showcase** avec `title`, `description`, `isPublic`
- **Relation ManyToOne** : Showcase (N) → (1) User
- **Relation ManyToMany** : Showcase (N) ↔ (N) Project

### Section 5.2.4 - Contrôleurs et vues
- **UserController** avec `index()`, `show(int $id)`
- **PortfolioController** avec `index()`, `show(int $id)`
- **Templates Twig** avec Bootstrap
- **ShowcaseController** - À créer (Phase 2)
- **CRUD complet** - À implémenter (Phase 2)

---

## Vérification de la base de données

### Tables créées (9)
- `user` - Utilisateurs avec référence portfolio_id (UNIQUE)
- `portfolio` - Portfolios personnels
- `project` - Projets avec référence portfolio_id
- `task` - Tâches avec référence project_id
- `showcase` - Galeries avec référence owner_id (user)
- `project_user` - Table de jointure Project↔User
- `showcase_project` - Table de jointure Showcase↔Project
- `messenger_messages` - Système de messages Symfony
- `sqlite_sequence` - Séquences SQLite

### Contraintes vérifiées
```sql
-- Contrainte OneToOne User↔Portfolio
CREATE UNIQUE INDEX UNIQ_8D93D649B96B5643 ON user (portfolio_id);
CREATE INDEX IDX_8D93D649B96B5643 ON user (portfolio_id);
CONSTRAINT FK_8D93D649B96B5643 FOREIGN KEY (portfolio_id) 
  REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
```

### Commandes de vérification
```bash
# Vérifier le mapping OneToOne User↔Portfolio
php bin/console dbal:run-sql "SELECT u.id, u.username, u.portfolio_id, p.description FROM user u JOIN portfolio p ON u.portfolio_id = p.id"

# Compter les projets par portfolio
php bin/console dbal:run-sql "SELECT p.id, p.description, COUNT(pr.id) as nb_projects FROM portfolio p LEFT JOIN project pr ON pr.portfolio_id = p.id GROUP BY p.id"

# Lister toutes les tables
php bin/console dbal:run-sql "SELECT name FROM sqlite_master WHERE type='table' ORDER BY name"

# Vérifier les fixtures
php bin/console dbal:run-sql "SELECT COUNT(*) FROM user"    # Résultat: 3
php bin/console dbal:run-sql "SELECT COUNT(*) FROM portfolio"  # Résultat: 3
php bin/console dbal:run-sql "SELECT COUNT(*) FROM project"    # Résultat: 4
php bin/console dbal:run-sql "SELECT COUNT(*) FROM task"       # Résultat: 11
php bin/console dbal:run-sql "SELECT COUNT(*) FROM showcase"   # Résultat: 3
```

---

## Références officielles

- **[Cahier des charges](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/cahier-charges-projet.html)**
- **[Guide de réalisation](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/)**
- **[Checklist officielle](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/checklist-projet.html)**

---

**Dernière mise à jour:** 18 novembre 2025  
