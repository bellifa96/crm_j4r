<?php

namespace App\Repository\Affaire;

use App\Entity\Affaire\CategorieOuvrage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieOuvrage>
 *
 * @method CategorieOuvrage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieOuvrage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieOuvrage[]    findAll()
 * @method CategorieOuvrage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieOuvrageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieOuvrage::class);
    }

    public function save(CategorieOuvrage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategorieOuvrage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CategorieOuvrage[] Returns an array of CategorieOuvrage objects
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

//    public function findOneBySomeField($value): ?CategorieOuvrage
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
