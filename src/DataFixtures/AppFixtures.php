<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Portfolio;
use App\Entity\Project;
use App\Entity\Task;
use App\Entity\Showcase;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Generates initialization data for users : [username, email, plain text password]
     * @return \Generator
     */
    private function usersGenerator()
    {
        yield ['orchidium', 'orchidium@minet.net', '123456'];
        yield ['liteapp', 'liteapp@minet.net', '123456'];
        yield ['andinoxis', 'andinoxis@minet.net', '123456'];
    }

    public function load(ObjectManager $manager): void
    {
        // Créer les Users avec leurs portfolios personnels
        $users = [];
        $portfolios = [];
        
        foreach ($this->usersGenerator() as [$username, $email, $plainPassword]) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);
            
            // Créer un portfolio personnel pour chaque utilisateur
            $portfolio = new Portfolio();
            $portfolio->setDescription("Portfolio personnel de " . $username);
            $user->setPortfolio($portfolio);
            
            $manager->persist($user);
            $users[$username] = $user;
            $portfolios[$username] = $portfolio;
        }
        
        $manager->flush();
        
        // Utiliser les portfolios personnels des users
        $portfolio1 = $portfolios['orchidium'];  // Portfolio d'Orchidium
        $portfolio2 = $portfolios['liteapp'];  // Portfolio de Liteapp
        // $portfolios['andinoxis'] existe aussi mais n'a pas encore de projets

        // Projet 1 : Serveur de stockage des logs
        $project1 = new Project();
        $project1->setTitle("Serveur de stockage des logs");
        $project1->setDescription("Refonte du système de stockage des logs de l'association");
        $project1->setStatus("in_progress");
        $project1->setStartDate(new \DateTime('2025-01-15'));
        $project1->setPortfolio($portfolio1);
        // Ajouter les contributeurs
        $project1->addMember($users['orchidium']);
        $project1->addMember($users['liteapp']);
        $manager->persist($project1);

        // Tasks pour Projet 1
        $task1 = new Task();
        $task1->setTitle("Acheter des disques");
        $task1->setDescription("Acheter des disques durs adaptés au stockage des logs");
        $task1->setStatus("done");
        $task1->setOrderPosition(1);
        $task1->setProject($project1);
        $manager->persist($task1);

        $task2 = new Task();
        $task2->setTitle("Installer le système");
        $task2->setDescription("Installer DSM et configurer le RAID");
        $task2->setStatus("in_progress");
        $task2->setOrderPosition(2);
        $task2->setProject($project1);
        $manager->persist($task2);

        $task3 = new Task();
        $task3->setTitle("Configurer les sauvegardes");
        $task3->setDescription("Mettre en place les sauvegardes automatiques");
        $task3->setStatus("not_started");
        $task3->setOrderPosition(3);
        $task3->setProject($project1);
        $manager->persist($task3);

        // Projet 2 : Migration Docker
        $project2 = new Project();
        $project2->setTitle("Migration vers Docker");
        $project2->setDescription("Conteneurisation de tous les services MiNET");
        $project2->setStatus("not_started");
        $project2->setPortfolio($portfolio1);
        // Ajouter les contributeurs
        $project2->addMember($users['orchidium']);
        $project2->addMember($users['andinoxis']);
        $manager->persist($project2);

        // Tasks pour Projet 2
        $task4 = new Task();
        $task4->setTitle("Auditer les services existants");
        $task4->setStatus("not_started");
        $task4->setOrderPosition(1);
        $task4->setProject($project2);
        $manager->persist($task4);

        $task5 = new Task();
        $task5->setTitle("Créer les Dockerfiles");
        $task5->setStatus("not_started");
        $task5->setOrderPosition(2);
        $task5->setProject($project2);
        $manager->persist($task5);

        // Projet 3 : Site web
        $project3 = new Project();
        $project3->setTitle("MAJ MiNET");
        $project3->setDescription("Actualisation de l'ensemble de nos services");
        $project3->setStatus("completed");
        $project3->setStartDate(new \DateTime('2024-09-01'));
        $project3->setEndDate(new \DateTime('2024-12-15'));
        $project3->setPortfolio($portfolio2);
        // Ajouter les contributeurs
        $project3->addMember($users['liteapp']);
        $manager->persist($project3);

        // Tasks pour Projet 3 (toutes terminées)
        $task6 = new Task();
        $task6->setTitle("Mettre à jour les machines");
        $task6->setStatus("done");
        $task6->setOrderPosition(1);
        $task6->setProject($project3);
        $manager->persist($task6);

        $task7 = new Task();
        $task7->setTitle("Mettre à jour les services");
        $task7->setStatus("done");
        $task7->setOrderPosition(2);
        $task7->setProject($project3);
        $manager->persist($task7);

        $task8 = new Task();
        $task8->setTitle("Déployer en production");
        $task8->setStatus("done");
        $task8->setOrderPosition(3);
        $task8->setProject($project3);
        $manager->persist($task8);

        // Projet 4 : API REST
        $project4 = new Project();
        $project4->setTitle("API REST");
        $project4->setDescription("Développement d'une API centralisée pour tous les services");
        $project4->setStatus("in_progress");
        $project4->setStartDate(new \DateTime('2025-02-01'));
        $project4->setPortfolio($portfolio2);
        // Ajouter les contributeurs
        $project4->addMember($users['liteapp']);
        $project4->addMember($users['andinoxis']);
        $manager->persist($project4);

        // Tasks pour Projet 4
        $task9 = new Task();
        $task9->setTitle("Définir les endpoints");
        $task9->setStatus("done");
        $task9->setOrderPosition(1);
        $task9->setProject($project4);
        $manager->persist($task9);

        $task10 = new Task();
        $task10->setTitle("Implémenter l'authentification");
        $task10->setStatus("in_progress");
        $task10->setOrderPosition(2);
        $task10->setProject($project4);
        $manager->persist($task10);

        $task11 = new Task();
        $task11->setTitle("Documenter l'API");
        $task11->setStatus("not_started");
        $task11->setOrderPosition(3);
        $task11->setProject($project4);
        $manager->persist($task11);

        $manager->flush();

        // Créer des Showcases (galeries)
        $showcase1 = new Showcase();
        $showcase1->setTitle("Projets Infrastructure 2025");
        $showcase1->setDescription("Vitrine des projets d'infrastructure en cours et terminés");
        $showcase1->setIsPublic(true);
        $showcase1->setOwner($users['orchidium']);
        $showcase1->addProject($project1);
        $showcase1->addProject($project2);
        $manager->persist($showcase1);

        $showcase2 = new Showcase();
        $showcase2->setTitle("Développement Web");
        $showcase2->setDescription("Mes projets de développement web et d'APIs");
        $showcase2->setIsPublic(true);
        $showcase2->setOwner($users['liteapp']);
        $showcase2->addProject($project3);
        $showcase2->addProject($project4);
        $manager->persist($showcase2);

        $showcase3 = new Showcase();
        $showcase3->setTitle("Projets en cours - Andinoxis");
        $showcase3->setDescription("Galerie privée de mes projets actuels");
        $showcase3->setIsPublic(false);
        $showcase3->setOwner($users['andinoxis']);
        $showcase3->addProject($project2);
        $showcase3->addProject($project4);
        $manager->persist($showcase3);

        $manager->flush();
    }
}
