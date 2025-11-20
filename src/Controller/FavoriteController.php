<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FavoriteController extends AbstractController
{
    private const SESSION_KEY = 'favorites';

    #[Route('/favorites', name: 'app_favorites_index', methods: ['GET'])]
    public function index(Request $request, ProjectRepository $projectRepository): Response
    {
        // Récupérer les IDs des favoris depuis la session
        $favoriteIds = $request->getSession()->get(self::SESSION_KEY, []);
        
        // Récupérer les projets correspondants
        $favorites = [];
        if (!empty($favoriteIds)) {
            $favorites = $projectRepository->findBy(['id' => $favoriteIds]);
        }

        return $this->render('favorite/index.html.twig', [
            'favorites' => $favorites,
            'count' => count($favoriteIds),
        ]);
    }

    #[Route('/favorites/toggle/{id}', name: 'app_favorites_toggle', methods: ['POST'])]
    public function toggle(int $id, Request $request, ProjectRepository $projectRepository): Response
    {
        // Vérifier le token CSRF
        if (!$this->isCsrfTokenValid('toggle-favorite'.$id, $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_project_index');
        }

        // Vérifier que le projet existe
        $project = $projectRepository->find($id);
        if (!$project) {
            throw $this->createNotFoundException('Projet non trouvé');
        }

        $session = $request->getSession();
        $favoriteIds = $session->get(self::SESSION_KEY, []);

        // Toggle: ajouter ou retirer
        if (in_array($id, $favoriteIds)) {
            // Retirer des favoris
            $favoriteIds = array_filter($favoriteIds, fn($favId) => $favId !== $id);
            $message = sprintf('Le projet "%s" a été retiré de vos favoris.', $project->getTitle());
            $type = 'info';
        } else {
            // Ajouter aux favoris
            $favoriteIds[] = $id;
            $message = sprintf('Le projet "%s" a été ajouté à vos favoris !', $project->getTitle());
            $type = 'success';
        }

        // Sauvegarder en session (réindexer le tableau)
        $session->set(self::SESSION_KEY, array_values($favoriteIds));
        $this->addFlash($type, $message);

        // Rediriger vers la page précédente ou la liste des projets
        $referer = $request->headers->get('referer');
        if ($referer) {
            return $this->redirect($referer);
        }
        
        return $this->redirectToRoute('app_project_index');
    }

    #[Route('/favorites/clear', name: 'app_favorites_clear', methods: ['POST'])]
    public function clear(Request $request): Response
    {
        // Vérifier le token CSRF
        if (!$this->isCsrfTokenValid('clear-favorites', $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_favorites_index');
        }

        $session = $request->getSession();
        $count = count($session->get(self::SESSION_KEY, []));
        
        $session->remove(self::SESSION_KEY);
        
        $this->addFlash('success', sprintf('Tous vos favoris (%d projet%s) ont été supprimés.', $count, $count > 1 ? 's' : ''));
        
        return $this->redirectToRoute('app_favorites_index');
    }
}
