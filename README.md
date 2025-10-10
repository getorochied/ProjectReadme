# README - Portfolio des projets MiNET
[Gustave Beauvallet](https://github.com/getorochied/ProjectReadme)

## Description du projet
Application Symfony de gestion de portfolios de projets permettant d'organiser et de présenter des projets avec leurs tâches associées.

## État actuel du développement

  - [x] Initialiser le projet Symfony 7
  - [x] Configurer la base de données SQLite
  - [x] Créer l'entité Portfolio
  - [x] Créer l'entité Project
  - [x] Créer l'entité Task (checklist)
  - [x] Ajouter la relation Portfolio → Projects (OneToMany)
  - [x] Ajouter la relation Project → Tasks (OneToMany)
  - [x] Créer les pages de consultation (liste et détail des portfolios)
  - [x] Intégrer Bootstrap pour la mise en forme
  - [x] Afficher les checklists dans les projets
  - [ ] Créer l'entité Member (utilisateurs)
  - [ ] Ajouter l'authentification Symfony
  - [ ] Gérer les contributeurs des projets (Many-to-Many)
  - [ ] Créer l'entité Showcase (vitrines publiques)


## Structure des entités
```
Portfolio (1) ←→ (N) Project (1) ←→ (N) Task
```

- **Portfolio** : Collection de projets avec description
- **Project** : Projet avec titre, description, statut, dates
- **Task** : Tâche avec titre, description, statut, position

## URLs principales
- `/portfolio` - Liste des portfolios
- `/portfolio/{id}` - Détail d'un portfolio et ses projets


## Consignes du projet
- [Cahier des charges](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/cahier-charges-projet.html)
- [Page principale du projet](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/)
- [Checklist du projet](https://www-inf.telecom-sudparis.eu/COURS/CSC4101/projet/checklist-projet.html)