<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Showcase;
use App\Form\ShowcaseType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user_index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_show', requirements: ['id' => '\d+'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/{id}/showcase/new', name: 'app_user_showcase_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function newShowcase(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $showcase = new Showcase();
        $showcase->setOwner($user);
        
        $form = $this->createForm(ShowcaseType::class, $showcase, [
            'disable_owner' => true
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($showcase);
            $entityManager->flush();

            $this->addFlash('success', sprintf('La showcase "%s" a été créée et liée à %s !', $showcase->getTitle(), $user->getUsername()));

            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('showcase/new.html.twig', [
            'showcase' => $showcase,
            'form' => $form,
            'user' => $user,
        ]);
    }
}