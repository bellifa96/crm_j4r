<?php

namespace App\Repository\Conversation;

use App\Entity\Conversation\ConversationChantier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConversationChantier>
 *
 * @method ConversationChantier|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationChantier|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationChantier[]    findAll()
 * @method ConversationChantier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationChantierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversationChantier::class);
    }

    public function save(ConversationChantier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConversationChantier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConversationChantier[] Returns an array of ConversationChantier objects
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

//    public function findOneBySomeField($value): ?ConversationChantier
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
