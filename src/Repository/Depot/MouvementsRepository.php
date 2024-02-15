<?php


namespace App\Repository\Depot;

use App\Entity\Depot\Mouvements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Mouvements>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne
 */

class MouvementsRepository extends ServiceEntityRepository
{

    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Mouvements::class);

        $this->em = $entityManager;
    }
 
    public function add(Mouvements $mouvements)
    {
        $this->_em->persist($mouvements);

        $this->_em->flush();
        return true;
    }

    /*
    * cette methode pour récuperer toute les depots
    *  return  toutes les depots avec ces agences 
    * 
    */
    public function mouvementes()
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();
    }
}
