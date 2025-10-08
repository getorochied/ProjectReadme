<?php

namespace App\DataFixtures;

use App\Entity\Portfolio;
use App\Entity\Project;
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
        $portfolio2->setDescription("Portfolio des projets web");
        $manager->persist($portfolio2);

        // Projets du portfolio Infrastructure
        $project1 = new Project();
        $project1->setTitle("Serveur de stockage NAS");
        $project1->setDescription("Mise en place d'un serveur de stockage pour l'association");
        $project1->setStatus("in_progress");
        $project1->setStartDate(new \DateTime('2025-01-15'));
        $project1->setPortfolio($portfolio1);
        $manager->persist($project1);

        $project2 = new Project();
        $project2->setTitle("Migration vers Docker");
        $project2->setDescription("Conteneurisation de tous les services MiNET");
        $project2->setStatus("not_started");
        $project2->setPortfolio($portfolio1);
        $manager->persist($project2);

        // Projets du portfolio Web
        $project3 = new Project();
        $project3->setTitle("Site web MiNET");
        $project3->setDescription("Refonte complète du site de l'association");
        $project3->setStatus("completed");
        $project3->setStartDate(new \DateTime('2024-09-01'));
        $project3->setEndDate(new \DateTime('2024-12-15'));
        $project3->setPortfolio($portfolio2);
        $manager->persist($project3);

        $project4 = new Project();
        $project4->setTitle("API REST");
        $project4->setDescription("Développement d'une API centralisée pour tous les services");
        $project4->setStatus("in_progress");
        $project4->setStartDate(new \DateTime('2025-02-01'));
        $project4->setPortfolio($portfolio2);
        $manager->persist($project4);

        $manager->flush();
    }
}