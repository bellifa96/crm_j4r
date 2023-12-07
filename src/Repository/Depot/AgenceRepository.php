<?php



namespace App\Repository\Depot;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Article;
use App\Entity\Depot\Agence;
use Exception;

/**
 * @extends ServiceEntityRepository<Agence>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne -> couche service -> couche web (Controller)
 */

class AgenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agence::class);
    }


    /* Utilise la réquete dql pour optimiser la requete  le temps c'est trés important
     ** 
    */

    public function findAll()
    {
        $dql = "SELECT a FROM App\Entity\Depot\Agence a";
        $query = $this->_em->createQuery($dql);
        $result = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return $result;
    }

    public function addAgence(Agence $agence)
    {
        try {
            $this->_em->persist($agence);
            $this->_em->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
   
}
