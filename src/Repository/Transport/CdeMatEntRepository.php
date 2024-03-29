<?php

namespace App\Repository\Transport;

use App\Entity\Transport\CdeMatEnt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CdeMatEnt>
 *
 * @method CdeMatEnt|null find($id, $lockMode = null, $lockVersion = null)
 * @method CdeMatEnt|null findOneBy(array $criteria, array $orderBy = null)
 * @method CdeMatEnt[]    findAll()
 * @method CdeMatEnt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CdeMatEntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CdeMatEnt::class);
    }

    public function save(CdeMatEnt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CdeMatEnt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CdeMatEnt[] Returns an array of CdeMatEnt objects
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

//    public function findOneBySomeField($value): ?CdeMatEnt
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
