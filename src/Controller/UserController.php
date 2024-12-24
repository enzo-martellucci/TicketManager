<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function edit(User $user): Response
    {
        return new Response();
    }

    #[Route('/users/{id}/delete', name: 'user_delete')]
    public function delete(User $user): Response
    {
        return new Response();
    }
}
