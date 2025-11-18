# TODO - Suivi du développement

**Progression globale:** 11/19 items OBLIGATOIRES complétés (57.9%)

---

## Phase 1 - Modèle de données et consultation (11/11 - 100% COMPLÉTÉE)

- [x] **#1** Prise de connaissance du cahier des charges (OBLIGATOIRE)
- [x] **#2** Initialisation du projet Symfony 7 LTS avec SQLite (OBLIGATOIRE)
- [x] **#3** Gestion du code source avec Git (RECOMMANDÉ)
- [x] **#4** Entités Portfolio et Project avec association 1-N (OBLIGATOIRE)
  - [x] #4.1 Entité Portfolio (ex-[inventaire])
  - [x] #4.2 Entité Project (ex-[objet])
  - [x] #4.3 Association 1-N entre Portfolio et Project
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

### Réussites de Phase 1
- Toutes les entités requises créées avec nomenclature correcte
- TOUTES les relations obligatoires implémentées (OneToOne, OneToMany, ManyToMany)
- Base de données fonctionnelle avec contraintes d'intégrité
- Fixtures générant données cohérentes automatiquement
- Pages de consultation avec templates Bootstrap
- Navigation fluide entre entités
- Entité bonus Showcase pour galeries publiques/privées

---

## Phase 2 - CRUD et contextualisation (0/5 - 0% EN ATTENTE)

- [ ] **#12** Contrôleur CRUD complet pour Showcase (OBLIGATOIRE)
  - Générer avec `php bin/console make:crud Showcase`
  - Méthodes: index, new, show, edit, delete
  - Formulaires pour création/édition
  
- [ ] **#13** Fonctions CRUD pour Project (OBLIGATOIRE)
  - Ajouter new, edit, delete à ProjectController
  - Créer ProjectType pour les formulaires
  - Validation des données
  
- [ ] **#14** Consultation des Projects depuis les Showcases publiques (OBLIGATOIRE)
  - Créer la route `/showcase` pour lister les showcases publiques
  - Créer la route `/showcase/{id}` pour voir les projets d'une showcase
  - Filtrer uniquement les showcases avec `isPublic = true`
  
- [ ] **#15** Liste des portfolios d'un User spécifique (OBLIGATOIRE)
  - Route `/user/{id}/portfolios` ou intégrer dans `/user/{id}`
  - Afficher le portfolio personnel de l'utilisateur
  
- [ ] **#16** Contextualisation création Project selon Portfolio (OBLIGATOIRE)
  - Route `/portfolio/{id}/project/new`
  - Le projet créé est automatiquement lié au portfolio
  - Redirection vers le portfolio après création

### Prochaine étape recommandée
**Item #12 - ShowcaseController CRUD** : `php bin/console make:crud Showcase`

---

## Phase 3 - Authentification et médias (0/3 - 0% EN ATTENTE)

- [ ] **#17** Upload d'images pour les Projects (OBLIGATOIRE)
  - Installer VichUploaderBundle ou gérer manuellement
  - Ajouter propriété `imagePath` à l'entité Project
  - Formulaire d'upload dans ProjectType
  - Affichage des images dans les templates
  
- [ ] **#18** Système d'authentification Symfony (OBLIGATOIRE)
  - Générer avec `php bin/console make:auth`
  - Formulaire de login/logout
  - Configurer `security.yaml`
  - Protéger les routes CRUD
  
- [ ] **#19** Filtrage: afficher uniquement les showcases publiques (OBLIGATOIRE)
  - Modifier ShowcaseRepository::findAll() pour filtrer `isPublic = true`
  - Page publique vs page admin
  - Les utilisateurs non connectés ne voient que les showcases publiques

---

## Optionnel - Améliorations (0/6 - BONUS)

- [ ] **#20** Contextualisation création Showcase par User
  - Route `/user/{id}/showcase/new`
  - La showcase est automatiquement liée à l'utilisateur connecté
  
- [ ] **#21** Contextualisation ajout Project à Showcase
  - Depuis la page d'un projet: bouton "Ajouter à une showcase"
  - Liste déroulante des showcases de l'utilisateur
  
- [ ] **#22** Messages flash pour les opérations CRUD
  - Success: "Projet créé avec succès"
  - Error: "Erreur lors de la suppression"
  - Info: "Modifications enregistrées"
  
- [ ] **#23** Système de marque-pages/panier dans le front-office
  - Session utilisateur pour stocker les favoris
  - Bouton "Ajouter aux favoris" sur chaque projet
  - Page `/favorites` pour voir tous les favoris
  
- [ ] **#24** Protection d'accès aux données (propriétaires uniquement)
  - Voters Symfony pour vérifier les permissions
  - Seul le propriétaire peut modifier/supprimer
  - Messages d'erreur appropriés
  
- [ ] **#25** Chargement contextuel selon utilisateur connecté
  - Dashboard personnalisé après login
  - Afficher uniquement les projets de l'utilisateur
  - Statistiques personnalisées

---

## 📋 Vérification de conformité avec le cahier des charges

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

## Points d'attention

### Relation User ←→ Portfolio IMPLÉMENTÉE
**Statut:** **COMPLET** (requis par cahier des charges section 5.2.4)

**Code implémenté:**
```php
// Dans User.php
#[ORM\OneToOne(inversedBy: 'owner', cascade: ['persist', 'remove'])]
#[ORM\JoinColumn(nullable: false)]
private ?Portfolio $portfolio = null;

// Dans Portfolio.php
#[ORM\OneToOne(mappedBy: 'portfolio')]
private ?User $owner = null;
```

### À implémenter en priorité (Phase 2)
- ShowcaseController avec CRUD complet
- ProjectController avec création/édition/suppression
- Navigation depuis Showcase vers Projects
- Contextualisation des créations par Portfolio

### Authentification manquante (Phase 3)
- Pas de formulaire de login/logout
- Pas de protection des routes
- Tous les utilisateurs voient les mêmes données
- Les passwords hashés en fixtures sont prêts mais inutilisés

### Upload d'images (Phase 3)
- Pas de propriété `imagePath` dans Project
- VichUploaderBundle à installer ou gestion manuelle
- Formulaire d'upload à créer

---

**Dernière mise à jour:** 18 novembre 2025  
**Version:** 1.1 - Phase 1 complète  
**Statut:** 11/11 Phase 1 | 0/5 Phase 2 | 0/3 Phase 3 | 0/6 Bonus
