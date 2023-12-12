<?php

namespace App\Repository\Transport;

use App\Entity\Transport\CdeMatDet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<CdeMatDet>
 *
 * @method CdeMatDet|null find($id, $lockMode = null, $lockVersion = null)
 * @method CdeMatDet|null findOneBy(array $criteria, array $orderBy = null)
 * @method CdeMatDet[]    findAll()
 * @method CdeMatDet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CdeMatDetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CdeMatDet::class);
    }

    public function save(CdeMatDet $entity, bool $flush = false): void
    {
        try {
            $this->_em->persist($entity);

            $this->_em->flush();

        } catch (Exception $e) {
           dd($e->getMessage());
        }
    }

    public function remove(CdeMatDet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


}
