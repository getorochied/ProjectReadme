# TODO - Suivi du développement

**Progression globale:** 19/19 items OBLIGATOIRES complétés (100% ✅)

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

## Phase 2 - CRUD et contextualisation (5/5 - 100% COMPLÉTÉE ✅)

- [x] **#12** Contrôleur CRUD complet pour Showcase (OBLIGATOIRE)
  - Généré avec `php bin/console make:crud Showcase`
  - Méthodes: index, new, show, edit, delete implémentées
  - Formulaires pour création/édition avec ShowcaseType
  - Templates Bootstrap améliorés avec design moderne
  - Lien ajouté dans la navbar principale

- [x] **#13** Fonctions CRUD pour Project (OBLIGATOIRE)
  - ProjectController créé avec toutes les méthodes CRUD
  - ProjectType avec 8 champs (title, description, status, dates, portfolio, members, showcases)
  - Templates Bootstrap: index (grille de cartes), show (détail complet), new/edit (formulaires)
  - Affichage des membres et tâches sur la page de détail
  - Lien "Projets" ajouté dans la navbar

- [x] **#14** Consultation des Projects depuis les Showcases publiques (OBLIGATOIRE)
  - Route `/showcase/public` créée pour lister uniquement les showcases publiques
  - Méthode `findPublicShowcases()` dans ShowcaseRepository
  - Template public.html.twig dédié aux showcases publiques
  - showcase/show.html.twig amélioré avec liens cliquables vers les projets
  - Navigation fluide: Showcases publiques → Showcase → Projets → Détail projet
  - Lien "Showcases Publiques" ajouté en premier dans la navbar
  
- [x] **#15** Liste des portfolios d'un User spécifique (OBLIGATOIRE)
  - ✅ Template user/show.html.twig AFFICHE DÉJÀ le portfolio personnel
  - ✅ Section "Portfolio Personnel" avec lien "Voir le portfolio complet"
  - ✅ Affichage du nombre de projets dans le portfolio
  - ✅ Lien "Retour au profil" ajouté dans portfolio/show.html.twig
  - ✅ Navigation contextuelle: Users → User #1 → Portfolio → back to User
  - ✅ Conformité complète avec guide section 14.1
  
- [x] **#16** Contextualisation création Project selon Portfolio (OBLIGATOIRE)
  - ✅ Route modifiée: `/portfolio/{id}/project/new` (au lieu de `/project/new`)
  - ✅ ProjectController::new() accepte Portfolio en paramètre
  - ✅ `$project->setPortfolio($portfolio)` auto-définit le portfolio
  - ✅ Champ portfolio DÉSACTIVÉ dans ProjectType (`'disabled' => true`)
  - ✅ Bouton "Créer un nouveau projet" DÉPLACÉ dans portfolio/show.html.twig
  - ✅ Bouton SUPPRIMÉ de project/index.html.twig
  - ✅ Redirection vers portfolio après création (app_portfolio_show)
  - ✅ Redirections edit() et delete() retournent au portfolio
  - ✅ Conformité complète avec guide section 14.2

### Phase 2 - Bilan
🎉 **PHASE 2 TERMINÉE À 100% !** Toutes les fonctionnalités CRUD et de contextualisation sont implémentées selon le guide de réalisation.

---

## Phase 3 - Authentification et médias (3/3 - 100% COMPLÉTÉE ✅)

- [x] **#17** Upload d'images pour les Projects (OBLIGATOIRE)
  - ✅ VichUploaderBundle v2.8.1 installé et configuré
  - ✅ Configuration vich_uploader.yaml avec mapping project_images
  - ✅ Entité Project modifiée: imageFile, imageName, imageSize, updatedAt
  - ✅ Bug résolu: utilisation de Annotation namespace (pas Attribute)
  - ✅ Formulaire ProjectType avec VichImageType (preview, delete, download)
  - ✅ Templates modifiés: _form, show, index pour affichage images
  - ✅ SmartUniqueNamer pour noms de fichiers uniques
  - ✅ Upload destination: public/uploads/projects/
  - ✅ Toutes les routes testées: HTTP 200
  
- [x] **#18** Système d'authentification Symfony (OBLIGATOIRE)
  - ✅ Généré avec `symfony console make:auth`
  - ✅ LoginFormAuthenticator créé avec redirection vers portfolio
  - ✅ SecurityController avec login() et logout()
  - ✅ security.yaml configuré: User entity provider, logout target
  - ✅ Template login.html.twig avec Bootstrap moderne
  - ✅ Protection CRUD avec #[IsGranted('ROLE_USER')] sur new/edit/delete
  - ✅ Navbar mise à jour: affiche username + déconnexion si connecté
  - ✅ Routes protégées redirigent vers login (HTTP 302)
  - ✅ Routes publiques accessibles (HTTP 200)
  
- [x] **#19** Filtrage: afficher uniquement les showcases publiques (OBLIGATOIRE)
  - ✅ ShowcaseController::index() filtre selon authentification
  - ✅ Utilisateur connecté: voir toutes les showcases (findAll)
  - ✅ Utilisateur anonyme: voir seulement publiques (findPublicShowcases)
  - ✅ ShowcaseController::show() protège accès aux showcases privées
  - ✅ Showcase privée → redirection login pour anonymes
  - ✅ Showcases publiques accessibles à tous
  - ✅ Tests validés: 2 showcases publiques visibles, 1 privée cachée

### Phase 3 - Bilan
🎉 **PHASE 3 TERMINÉE À 100% !** Système d'authentification complet, upload d'images fonctionnel, filtrage des showcases selon le statut de connexion.

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
**Version:** 1.4 - Phase 2 à 60% (Showcase + Project CRUD + Navigation publique)  
**Statut:** 11/11 Phase 1 | 3/5 Phase 2 | 0/3 Phase 3 | 0/6 Bonus
