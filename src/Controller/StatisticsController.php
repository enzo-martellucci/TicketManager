<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TicketRepository;

class StatisticsController extends AbstractController
{
    #[Route('/statistics', name: 'statistics_index')]
    public function index(TicketRepository $ticketRepository): Response
    {
        $ticketsByStatus = $ticketRepository->countTicketsByStatus();
        $ticketsByPriority = $ticketRepository->countTicketsByPriority();

        return $this->render('statistics/index.html.twig', [
            'ticketsByStatus' => json_encode($ticketsByStatus),
            'ticketsByPriority' => json_encode($ticketsByPriority),
        ]);
    }
}
