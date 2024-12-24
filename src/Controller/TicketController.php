<?php

namespace App\Controller;

use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TicketController extends AbstractController
{
    #[Route('/tickets', name: 'ticket_index')]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
        ]);
    }

    #[Route('/tickets/{id}/show', name: 'ticket_show')]
    public function show(): Response
    {
        return $this->render('ticket/show.html.twig', [
        ]);
    }

    #[Route('/tickets/create', name: 'ticket_create')]
    public function create(): Response
    {
        return $this->render('ticket/create.html.twig', [
        ]);
    }

    #[Route('/tickets/{id}/edit', name: 'ticket_edit')]
    public function edit(): Response
    {
        return $this->render('ticket/edit.html.twig', [
        ]);
    }

    #[Route('/tickets/{id}/delete', name: 'ticket_delete')]
    public function delete(Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($ticket);
        $entityManager->flush();
        return $this->redirectToRoute('ticket_index');
    }
}
