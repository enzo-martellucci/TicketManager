<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use App\Repository\TicketStatusHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TicketController extends AbstractController
{
    #[Route('/', name: 'root')]
    #[Route('/tickets', name: 'ticket_index')]
    public function index(TicketRepository $repository): Response
    {
        $tickets = $repository->findAll();

        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets
        ]);
    }

    #[Route('/tickets/{id}/show', name: 'ticket_show')]
    public function show(Ticket $ticket, TicketStatusHistoryRepository $repository): Response
    {
        $history = $repository->findBy(['ticket_id' => $ticket->getId()]);
        usort($history, function ($a, $b) {
            return -($a->getChangedAt()->getTimestamp() <=> $b->getChangedAt()->getTimestamp());
        });

        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
            'history' => $history
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
