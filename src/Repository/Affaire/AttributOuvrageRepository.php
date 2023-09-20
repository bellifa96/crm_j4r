<?php

namespace App\Repository\Affaire;

use App\Entity\Affaire\AttributOuvrage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AttributOuvrage>
 *
 * @method AttributOuvrage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttributOuvrage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttributOuvrage[]    findAll()
 * @method AttributOuvrage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributOuvrageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttributOuvrage::class);
    }

    public function save(AttributOuvrage $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AttributOuvrage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAttributByOuvrageId(int $id)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->innerJoin('a.ouvrage', 'o')
            ->where('o.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return AttributOuvrage[] Returns an array of AttributOuvrage objects
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

//    public function findOneBySomeField($value): ?AttributOuvrage
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
