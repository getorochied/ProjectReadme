<?php

namespace App\Controller;

use App\Repository\PortfolioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Portfolio;

class PortfolioController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        // Redirection vers la liste des portfolios
        return $this->redirectToRoute('app_portfolio_index');
    }

    #[Route('/portfolio', name: 'app_portfolio_index')]
    public function index(PortfolioRepository $portfolioRepository): Response
    {
        // Charger tous les portfolios depuis la base de données
        $portfolios = $portfolioRepository->findAll();

        return $this->render('portfolio/index.html.twig', [
            'portfolios' => $portfolios,
        ]);
    }
    #[Route('/portfolio/{id}', name: 'app_portfolio_show', requirements: ['id' => '\d+'])]
    public function show(Portfolio $portfolio): Response
    {
        return $this->render('portfolio/show.html.twig', [
            'portfolio' => $portfolio,
        ]);
    }
}