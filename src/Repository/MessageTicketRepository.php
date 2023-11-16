<?php

namespace App\Repository;

use App\Entity\MessageTicket;
use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MessageTicket>
 *
 * @method MessageTicket|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageTicket|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageTicket[]    findAll()
 * @method MessageTicket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageTicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageTicket::class);
    }

    //    /**
    //     * @return MessageTicket[] Returns an array of MessageTicket objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MessageTicket
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findMessageTicketsByTicket(Ticket $ticket)
    {
        return $this->createQueryBuilder('mt')
            ->andWhere('mt.ticket = :ticket')
            ->setParameter('ticket', $ticket)
            ->getQuery()
            ->getResult();
    }
}
