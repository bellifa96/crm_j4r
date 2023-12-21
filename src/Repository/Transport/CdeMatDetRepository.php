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
    public function article_by_numCloud_id_typeMat($idCloud, $article, $typeMat)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.NumCloud = :idCloud')
            ->andWhere('c.Article = :article')
            ->andWhere('c.TypeMat = :typeMat')
            ->setParameter('idCloud', $idCloud)
            ->setParameter('article', $article)
            ->setParameter('typeMat', $typeMat)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function articles_by_cde($idCdeMatEnt)
    {
        return $this->createQueryBuilder('e')
            ->where('e.IdCdeMatEnt = :idCdeMatEnt')
            ->setParameter('idCdeMatEnt', $idCdeMatEnt)
            ->getQuery()
            ->getResult();
    }
    public function updateQteSortieById(int $cdeMatDetId, int $newQteSortie): void
    {
        $qb = $this->createQueryBuilder('c')
            ->update()
            ->set('c.QteSortie', 'c.QteSortie + :newQteSortie')
            ->where('c.id = :cdeMatDetId')
            ->setParameter('newQteSortie', $newQteSortie)
            ->setParameter('cdeMatDetId', $cdeMatDetId);

        $qb->getQuery()->execute();
        
        $this->getEntityManager()->flush();

    }
}
