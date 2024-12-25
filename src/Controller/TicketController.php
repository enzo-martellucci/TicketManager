<?php

namespace App\Controller;

use App\Config\Status;
use App\Entity\Ticket;
use App\Entity\TicketStatusHistory;
use App\Form\CreateTicketType;
use App\Form\EditTicketType;
use App\Repository\TicketRepository;
use App\Repository\TicketStatusHistoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TicketController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'root')]
    #[Route('/tickets', name: 'ticket_index')]
    public function index(UserRepository $userRepository, TicketRepository $ticketRepository): Response
    {
        $user = $userRepository->find($this->getUser());
        if (in_array('ROLE_USER', $user->getRoles(), true)) {
            $tickets = $ticketRepository->findAll();
        } else if (in_array('ROLE_SUPPORT', $user->getRoles(), true)) {
            $tickets = $ticketRepository->findTicketBySupport($user->getId());
        } else {
            $tickets = $ticketRepository->findAll();
        }

        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets
        ]);
    }

    #[IsGranted('ROLE_USER')]
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

    #[IsGranted('ROLE_USER')]
    #[Route('/tickets/create', name: 'ticket_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $ticket->setStatus(Status::OPEN);

        $form = $this->createForm(CreateTicketType::class, $ticket);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTimeImmutable();
            $ticket->setCreatedAt($date)
                ->setUpdatedAt($date);

            $history = new TicketStatusHistory();
            $history->setTicketId($ticket)
                ->setChangedBy($this->getUser())
                ->setStatus(Status::OPEN)
                ->setChangedAt($date);

            $entityManager->persist($ticket);
            $entityManager->persist($history);
            $entityManager->flush();

            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('ticket/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/tickets/{id}/edit', name: 'ticket_edit')]
    public function edit(Ticket $ticket, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditTicketType::class, $ticket);

        $previousStatus = $ticket->getStatus();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($previousStatus !== $ticket->getStatus()) {
                $date = new \DateTimeImmutable();
                $ticket->setUpdatedAt($date);

                $history = new TicketStatusHistory();
                $history->setTicketId($ticket)
                    ->setChangedBy($this->getUser())
                    ->setStatus($ticket->getStatus())
                    ->setChangedAt($date);

                $entityManager->persist($history);
            }

            $entityManager->flush();

            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('ticket/edit.html.twig', [
            'form' => $form
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
