<?php

namespace App\Repository\Conversation;

use App\Entity\Conversation\ConversationMetreDemande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConversationMetreDemande>
 *
 * @method ConversationMetreDemande|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationMetreDemande|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationMetreDemande[]    findAll()
 * @method ConversationMetreDemande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationMetreDemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversationMetreDemande::class);
    }

    public function add(ConversationMetreDemande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConversationMetreDemande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConversationMetreDemande[] Returns an array of ConversationMetreDemande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ConversationMetreDemande
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
