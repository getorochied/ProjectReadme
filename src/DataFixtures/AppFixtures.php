<?php

namespace App\DataFixtures;

use App\Entity\Portfolio;
use App\Entity\Project;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Portfolio 1 : Infrastructure
        $portfolio1 = new Portfolio();
        $portfolio1->setDescription("Portfolio des projets infrastructure");
        $manager->persist($portfolio1);

        // Portfolio 2 : Web
        $portfolio2 = new Portfolio();
        $portfolio2->setDescription("Portfolio des services web");
        $manager->persist($portfolio2);

        // Projet 1 : Serveur de stockage des logs
        $project1 = new Project();
        $project1->setTitle("Serveur de stockage des logs");
        $project1->setDescription("Refonte du système de stockage des logs de l'association");
        $project1->setStatus("in_progress");
        $project1->setStartDate(new \DateTime('2025-01-15'));
        $project1->setPortfolio($portfolio1);
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
    }
}