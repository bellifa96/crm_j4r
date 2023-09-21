<?php

namespace App\Repository\Affaire;

use App\Entity\Affaire\AutreOuvrage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AutreOuvrage>
 *
 * @method AutreOuvrage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutreOuvrage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutreOuvrage[]    findAll()
 * @method AutreOuvrage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutreOuvrageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AutreOuvrage::class);
    }

    public function save(AutreOuvrage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AutreOuvrage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AutreOuvrage[] Returns an array of AutreOuvrage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AutreOuvrage
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
