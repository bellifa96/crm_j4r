<?php



namespace App\Repository\Depot;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Article;
use App\Entity\Depot\Agence;
use App\Entity\Depot\Mouvements;
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
            dd($e->getMessage());
            return false;
        }
    }

    public function getAgenceById(int $id): ?Agence
    {
        // Retrieve the Agence entity by its ID
        try{
            $agence = $this->_em->getRepository(Agence::class)->find($id);

            return $agence;
        }catch(Exception $e){
             return null;
        }
       
    }

    public function deleteAgenceById(Agence $agence)
    {
        if ($agence) {
            // Remove the entity
            $this->_em->remove($agence);
            // Commit the changes to the database
            $this->_em->flush();
            return 200;
        } else {
            return 500;
        }
    }

    public function getMouvementsByAgence(Agence $agence): array
    {
        // Retrieve all Mouvements associated with the provided Agence
        


        $mouvements = $this->_em->getRepository(Mouvements::class)->findBy(['idagence' => $agence]);

        return $mouvements;
    }
   
}
