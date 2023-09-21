<?php

namespace App\Repository\Affaire;

use App\Entity\Affaire\TableDePrix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TableDePrix>
 *
 * @method TableDePrix|null find($id, $lockMode = null, $lockVersion = null)
 * @method TableDePrix|null findOneBy(array $criteria, array $orderBy = null)
 * @method TableDePrix[]    findAll()
 * @method TableDePrix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableDePrixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TableDePrix::class);
    }

    public function save(TableDePrix $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TableDePrix $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TableDePrix[] Returns an array of TableDePrix objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TableDePrix
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /*public function findCadenceDeRerefence(){
            return $this->createQueryBuilder('t')
           ->andWhere('t.exampleField = :val')
           ->getQuery()
           ->getResult()
        ;
    }*/
}
