<?php


namespace App\Repository\Depot;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Depot\Depot;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Depot>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne
 */

class DepotRepository extends ServiceEntityRepository
{

    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Depot::class);

        $this->em = $entityManager;
    }


    /*
    * cette methode pour récuperer toute les depots
    *  return  toutes les depots avec ces agences 
    * 
    */
    public function getAllDepot()
    {

        $query = $this->createQueryBuilder('d')
            ->addSelect('a') 
            ->leftJoin('d.agence', 'a')
            ->getQuery();

        $depot = $query->getResult();

        return $depot;
    }

 
}
