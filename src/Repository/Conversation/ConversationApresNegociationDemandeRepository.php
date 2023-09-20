<?php

namespace App\Repository\Conversation;

use App\Entity\Conversation\ConversationApresNegociationDemande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConversationApresNegociationDemande>
 *
 * @method ConversationApresNegociationDemande|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationApresNegociationDemande|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationApresNegociationDemande[]    findAll()
 * @method ConversationApresNegociationDemande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationApresNegociationDemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversationApresNegociationDemande::class);
    }

    public function add(ConversationApresNegociationDemande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConversationApresNegociationDemande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConversationApresNegociationDemande[] Returns an array of ConversationApresNegociationDemande objects
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

//    public function findOneBySomeField($value): ?ConversationApresNegociationDemande
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
