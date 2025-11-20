<?php

namespace App\Controller;

use App\Entity\Showcase;
use App\Form\ShowcaseType;
use App\Repository\ShowcaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/showcase')]
final class ShowcaseController extends AbstractController
{
    #[Route('/public', name: 'app_showcase_public', methods: ['GET'])]
    public function public(ShowcaseRepository $showcaseRepository): Response
    {
        return $this->render('showcase/public.html.twig', [
            'showcases' => $showcaseRepository->findPublicShowcases(),
        ]);
    }

    #[Route(name: 'app_showcase_index', methods: ['GET'])]
    public function index(ShowcaseRepository $showcaseRepository): Response
    {
        // Si l'utilisateur est connecté, afficher toutes les showcases
        // Sinon, afficher uniquement les showcases publiques
        if ($this->getUser()) {
            $showcases = $showcaseRepository->findAll();
        } else {
            $showcases = $showcaseRepository->findPublicShowcases();
        }

        return $this->render('showcase/index.html.twig', [
            'showcases' => $showcases,
        ]);
    }

    #[Route('/new', name: 'app_showcase_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $showcase = new Showcase();
        $form = $this->createForm(ShowcaseType::class, $showcase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($showcase);
            $entityManager->flush();

            return $this->redirectToRoute('app_showcase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('showcase/new.html.twig', [
            'showcase' => $showcase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_showcase_show', methods: ['GET'])]
    public function show(Showcase $showcase): Response
    {
        // Si la showcase est privée et l'utilisateur n'est pas connecté, refuser l'accès
        if (!$showcase->isPublic() && !$this->getUser()) {
            throw $this->createAccessDeniedException('Cette showcase est privée. Veuillez vous connecter.');
        }

        return $this->render('showcase/show.html.twig', [
            'showcase' => $showcase,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_showcase_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Showcase $showcase, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ShowcaseType::class, $showcase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_showcase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('showcase/edit.html.twig', [
            'showcase' => $showcase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_showcase_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Showcase $showcase, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$showcase->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($showcase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_showcase_index', [], Response::HTTP_SEE_OTHER);
    }
}
