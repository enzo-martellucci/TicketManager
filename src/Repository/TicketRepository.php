<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function findTicketBySupport(int $id): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.assigned_to = :user')
            ->setParameter('user', $id)
            ->getQuery()
            ->getResult();
    }

    public function countTicketsByStatus(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.status as status, COUNT(t.id) as count')
            ->groupBy('t.status')
            ->getQuery()
            ->getResult();
    }
    

    public function countTicketsByPriority(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.priority as priority, COUNT(t.id) as count')
            ->groupBy('t.priority')
            ->getQuery()
            ->getResult();
    }
    
}
