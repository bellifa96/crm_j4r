<?php



namespace App\Repository\Depot;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Article;
use App\Entity\Depot\Agence;
use App\Entity\Depot\Articles;
use App\Entity\Depot\Depot;
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
        try {
            $agence = $this->_em->getRepository(Agence::class)->find($id);

            return $agence;
        } catch (Exception $e) {
            return null;
        }
    }

    public function deleteAgenceById(Agence $agence)
    {
        try {
            if ($agence) {
                // First, remove articles associated with each depot in the agence
                $depots = $this->_em->getRepository(Depot::class)->findBy(['agence' => $agence->getIdagence()]);
                
                foreach ($depots as $depot) {
                    // Assuming you have a method to get articles by depot (and possibly agence if needed)
                    $articles = $this->_em->getRepository(Articles::class)->findBy(['depot' => $depot->getIddepot(), 'idagence' => $agence->getIdagence()]);
                    
                    foreach ($articles as $article) {
                        $this->_em->remove($article);
                    }
    
                    // Now, remove the depot itself
                    $this->_em->remove($depot);
                }
    
                // After all depots (and their articles) have been removed, remove the agence
                $this->_em->remove($agence);
                
                // Commit the changes to the database
                $this->_em->flush();
                
                return 200;
            } else {
                return 500;
            }
        } catch (Exception $exception) {
            // Consider logging the exception details for debugging
            dd($exception); // Debugging only, remove or replace with logging in production
            return 500;
        }
    }

    public function getMouvementsByAgence(Agence $agence): array
    {
        // Retrieve all Mouvements associated with the provided Agence

        $mouvements = $this->_em->getRepository(Mouvements::class)->findBy(['idagence' => $agence]);

        return $mouvements;
    }
    public function getAgenceByAgence()
    {
        // Retrieve all Mouvements associated with the provided Agence
        try{
            $agencebyID   =$this->_em->getRepository(Agence::class)->findOneBy([
                'agence' => 1,
            ]);
            $depot = $this->_em->getRepository(Depot::class)->findOneBy([
                'agence' => $agencebyID->getIdagence() ,
                'codedepot' => 1,
            ]);
    
            return $depot;
        }catch(Exception $e){
             return null;
        }
       
    }
}
