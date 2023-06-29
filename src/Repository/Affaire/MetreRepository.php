<?php

namespace App\Repository\Affaire;

use App\Entity\Affaire\Metre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Metre>
 *
 * @method Metre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Metre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Metre[]    findAll()
 * @method Metre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Metre::class);
    }

    public function save(Metre $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Metre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function sommeLongueurs($hauteur): float
    {
        $qb = $this->createQueryBuilder('m');

        $qb->select('SUM(m.longueur)')
            ->where('m.longueurHauteur  = :hauteur')
            ->setParameter('hauteur', $hauteur);

        $result = $qb->getQuery()->getSingleScalarResult();

        return (float) $result;
    }


//    /**
//     * @return Metre[] Returns an array of Metre objects
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

//    public function findOneBySomeField($value): ?Metre
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
