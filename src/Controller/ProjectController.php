<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Portfolio;
use App\Entity\Showcase;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\ShowcaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/portfolio/{id}/project/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager, Portfolio $portfolio): Response
    {
        $project = new Project();
        $project->setPortfolio($portfolio);
        
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            $this->addFlash('success', sprintf('Le projet "%s" a été créé avec succès !', $project->getTitle()));

            return $this->redirectToRoute('app_portfolio_show', ['id' => $portfolio->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form,
            'portfolio' => $portfolio,
        ]);
    }

    #[Route('/project/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/project/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur est le propriétaire du portfolio
        $this->denyAccessUnlessGranted('EDIT', $project);

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', sprintf('Le projet "%s" a été modifié avec succès !', $project->getTitle()));

            return $this->redirectToRoute('app_portfolio_show', ['id' => $project->getPortfolio()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/project/{projectId}/add-to-showcase/{showcaseId}', name: 'app_project_add_to_showcase', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function addToShowcase(
        int $projectId,
        int $showcaseId,
        ProjectRepository $projectRepository,
        ShowcaseRepository $showcaseRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $project = $projectRepository->find($projectId);
        $showcase = $showcaseRepository->find($showcaseId);

        if (!$project || !$showcase) {
            throw $this->createNotFoundException('Project or Showcase not found');
        }

        // Vérifier que l'utilisateur connecté est le propriétaire de la showcase
        if ($showcase->getOwner() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only add projects to your own showcases');
        }

        // Vérifier le token CSRF
        if ($this->isCsrfTokenValid('add-to-showcase'.$project->getId(), $request->request->get('_token'))) {
            // Ajouter le projet à la showcase (si pas déjà présent)
            if (!$showcase->getProjects()->contains($project)) {
                $showcase->addProject($project);
                $entityManager->flush();
                $this->addFlash('success', sprintf('Le projet "%s" a été ajouté à la showcase "%s" !', $project->getTitle(), $showcase->getTitle()));
            } else {
                $this->addFlash('info', sprintf('Le projet "%s" est déjà dans la showcase "%s".', $project->getTitle(), $showcase->getTitle()));
            }
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_project_show', ['id' => $project->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/project/{id}', name: 'app_project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur est le propriétaire du portfolio
        $this->denyAccessUnlessGranted('DELETE', $project);

        $portfolioId = $project->getPortfolio()->getId();
        $projectTitle = $project->getTitle();
        
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
            $this->addFlash('success', sprintf('Le projet "%s" a été supprimé avec succès.', $projectTitle));
        } else {
            $this->addFlash('error', 'Token CSRF invalide. Le projet n\'a pas été supprimé.');
        }

        return $this->redirectToRoute('app_portfolio_show', ['id' => $portfolioId], Response::HTTP_SEE_OTHER);
    }
}
