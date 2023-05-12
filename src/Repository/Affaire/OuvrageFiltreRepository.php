<?php

namespace App\Repository\Affaire;

use App\Entity\Affaire\OuvrageFiltre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OuvrageFiltre>
 *
 * @method OuvrageFiltre|null find($id, $lockMode = null, $lockVersion = null)
 * @method OuvrageFiltre|null findOneBy(array $criteria, array $orderBy = null)
 * @method OuvrageFiltre[]    findAll()
 * @method OuvrageFiltre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OuvrageFiltreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OuvrageFiltre::class);
    }

    public function save(OuvrageFiltre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OuvrageFiltre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OuvrageFiltre[] Returns an array of OuvrageFiltre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OuvrageFiltre
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
