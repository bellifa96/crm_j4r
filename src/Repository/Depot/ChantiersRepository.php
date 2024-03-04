<?php
// src/Repository/ArticleRepository.php

namespace App\Repository\Depot;

use App\Entity\Depot\Chantiers;
use App\Entity\Depot\Chauffeurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Chauffeurs>
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
        ->select('d.idchantier, d.nomchantier,d.numchantier') // Select only id and nomdepot fields
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

   

 




  
}