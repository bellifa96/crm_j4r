<?php

namespace App\Repository\Interlocuteur;

use App\Entity\Interlocuteur\Interlocuteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Interlocuteur>
 *
 * @method Interlocuteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interlocuteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interlocuteur[]    findAll()
 * @method Interlocuteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterlocuteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interlocuteur::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Interlocuteur $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Interlocuteur $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Interlocuteur[] Returns an array of Interlocuteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Interlocuteur
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllByRole($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.roles LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
