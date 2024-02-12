<?php


namespace App\Repository\Depot;

use App\Entity\Depot\Paramagence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Paramagence>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne
 */

class ParamAgenceRepository extends ServiceEntityRepository
{

    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Paramagence::class);

        $this->em = $entityManager;
    }


    /*
    * cette methode pour récuperer toute les depots
    *  return  toutes les depots avec ces agences 
    * 
    */
    public function getTokens()
    {
        return $this->createQueryBuilder('p')
            ->select('p.accesstoken')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
