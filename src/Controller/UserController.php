<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users')]
    public function show(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/users/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('users');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }

    #[Route('/users/{id}/delete', name: 'user_delete')]
    public function delete(User $user): Response
    {
        return new Response();
    }
}
