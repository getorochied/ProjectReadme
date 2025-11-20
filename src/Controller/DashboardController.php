<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProjectRepository;
use App\Repository\ShowcaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function index(
        ProjectRepository $projectRepository,
        ShowcaseRepository $showcaseRepository
    ): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        
        // Récupérer le portfolio de l'utilisateur
        $portfolio = $user->getPortfolio();
        
        // Statistiques
        $stats = [
            'totalProjects' => 0,
            'totalShowcases' => 0,
            'completedProjects' => 0,
            'inProgressProjects' => 0,
        ];
        
        if ($portfolio) {
            $projects = $portfolio->getProjects();
            $stats['totalProjects'] = count($projects);
            
            foreach ($projects as $project) {
                if ($project->getStatus() === 'completed') {
                    $stats['completedProjects']++;
                } elseif ($project->getStatus() === 'in_progress') {
                    $stats['inProgressProjects']++;
                }
            }
        }
        
        // Showcases de l'utilisateur
        $showcases = $showcaseRepository->findBy(['owner' => $user]);
        $stats['totalShowcases'] = count($showcases);
        
        // Projets récents (3 derniers)
        $recentProjects = [];
        if ($portfolio) {
            $allProjects = $portfolio->getProjects()->toArray();
            // Trier par ID décroissant pour avoir les plus récents
            usort($allProjects, fn($a, $b) => $b->getId() <=> $a->getId());
            $recentProjects = array_slice($allProjects, 0, 3);
        }
        
        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'portfolio' => $portfolio,
            'stats' => $stats,
            'recentProjects' => $recentProjects,
            'showcases' => $showcases,
        ]);
    }
}
