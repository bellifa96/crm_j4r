<?php


namespace App\Repository\Depot;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Depot\Depot;
use App\Entity\Depot\Mouvements;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

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

        $dql = "SELECT d.iddepot,d.nomdepot,d.adressedepot,d.cpdepot,d.villedepot,d.contacttel FROM App\Entity\Depot\Depot d";
        $query = $this->_em->createQuery($dql);
        $result = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return $result;
    }
    public function add_update_depot(Depot $agence)
    {
        try {
            $this->_em->persist($agence);
            $this->_em->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function getDepotsByAgenceId($agenceId)
    {
        return $this->createQueryBuilder('d')
            ->select('d.iddepot, d.nomdepot,d.adressedepot, d.cpdepot,d.contacttel, d.villedepot,d.codedepot,d.contactportable') // Select only id and nomdepot fields
            ->andWhere('d.agence = :agenceId')  // Corrected to provide a condition
            ->setParameter('agenceId', $agenceId)
            ->getQuery()
            ->getResult();
    }
    public function findOneByCodedepot($chantier)
    {   
         return $this->findOneBy(['codedepot' => ($chantier == 20143) ? 2 : 1])->getIddepot();
    }
    public function findOneByidDepotCode($chantier)
    {   
         return $this->findOneBy(['codedepot' => ($chantier == 20143) ? 2 : 1]);
    }

    public function findOneByCodedepot1($codeDepot)
    {   
         return $this->findOneBy(['codedepot' => $codeDepot]);
    }

    public function findOneByIdDepot($id_depot)
    {   
         return $this->findOneBy(['iddepot' => $id_depot]);
    }

    public function getMouvementsByDepot(Depot $depot): array
    {
        // Retrieve all Mouvements associated with the provided Agence
        $mouvements = $this->_em->getRepository(Mouvements::class)->findBy(['iddepot' => $depot]);

        return $mouvements;
    }

    public function deleteDepotById(Depot $depot)
    {
        if ($depot) {
            // Remove the entity
            $this->_em->remove($depot);
            // Commit the changes to the database
            $this->_em->flush();
            return 200;
        } else {
            return 500;
        }
    }

}
