<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ticket;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Mettre les tickets pour pouvoir les utiliser dans le dash board pour faire l'affichage
        // $tickets = $entityManager->getRepository(Ticket::class)->findAll(); ////////// un truc comme ca il me semble

        return $this->render('dashboard/index.html.twig', [
            // 'tickets' => $tickets ///////// un truc du genre si on se refere a ce que j'ai trouvé pour le dessus 
        ]);
    }
}
