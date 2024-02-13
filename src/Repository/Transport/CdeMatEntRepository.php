<?php

namespace App\Repository\Transport;

use App\Entity\Transport\CdeMatEnt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

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

    public function save(CdeMatEnt $entity, bool $flush = false): int
    {
        try {
            $this->_em->persist($entity);
            $this->_em->flush();
            return $entity->getId();
        } catch (Exception $e) {
            dd($e->getMessage());
            return -1;
        }
    }

    public function remove(CdeMatEnt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function listCommandebyIdepot($Iddepot)
    { 
        
        $data =  $this->createQueryBuilder('c')
            ->andWhere('c.Iddepot = :Iddepot')
            ->andWhere('c.Actif = true')

            ->setParameter('Iddepot', $Iddepot)
            ->orderBy('c.DateCde', 'DESC') // Adding the ORDER BY clause
            ->getQuery()
            ->getResult();
        return $data;
    }

    public function listCommandebyIdDepotAnnuler($Iddepot)
    { 
        
        $data =  $this->createQueryBuilder('c')
            ->andWhere('c.Iddepot = :Iddepot')
            ->andWhere('c.Actif = false')

            ->setParameter('Iddepot', $Iddepot)
            ->orderBy('c.DateCde', 'DESC') // Adding the ORDER BY clause
            ->getQuery()
            ->getResult();
        return $data;
    }

    public function commandeByNumeroCloud($idCloud)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.numCloud = :idCloud')
            ->setParameter('idCloud', $idCloud)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function annuler_commande($motif,$idCommande){
        try{
            $commande = $this->_em->getRepository(CdeMatEnt::class)->find($idCommande);

            if (!$commande) {
                throw $this->createNotFoundException(
                    'No commande found for id '.$idCommande
                );
            }
        
            // Set the motif
            $commande->setMotif($motif);
        
            // Change the actif status
            $commande->setActif(false);
        
            // Persist the changes
            $this->_em->flush();
            return 200;
        }catch(Exception $e){
              return 500;
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
