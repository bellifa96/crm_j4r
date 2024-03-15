<?php
// src/Repository/ArticleRepository.php

namespace App\Repository\Depot;

use App\Entity\Depot\Chantiers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Chantiers>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne -> couche service -> couche web (Controller)
 */

class ChantiersRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chantiers::class);
    }

    public function getAllChantiersbyAgence($idagence){
        return $this->createQueryBuilder('d')
        ->select('d.idchantier, d.nomchantier,d.numchantier,d.ville,d.client') // Select only id and nomdepot fields
        ->andWhere('d.idagence = :agenceId')  // Corrected to provide a condition
        ->setParameter('agenceId', $idagence)
        ->getQuery()
        ->getResult();
    }

    public function getAllChantiers(){
        return $this->createQueryBuilder('d')
        ->select('d') // Select only id and nomdepot fields
        ->getQuery()
        ->getResult();
    }
    
    public function add_update_depot(Chantiers $agence)
    {
        try {
            $this->_em->persist($agence);
            $this->_em->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function findById($id)
    {
       return  $this->_em->createQueryBuilder()
        ->select('ch.adresse')
        ->from(Chantiers::class, 'ch')
        ->andWhere('ch.idchantier = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    }
    public function findByIdChantier($id)
    {
       return  $this->_em->createQueryBuilder()
        ->select('ch')
        ->from(Chantiers::class, 'ch')
        ->andWhere('ch.idchantier = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getOneOrNullResult();

    }

 




  
}