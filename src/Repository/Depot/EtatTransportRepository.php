<?php
// src/Repository/ArticleRepository.php

namespace App\Repository\Depot;

use App\Entity\Depot\Etatstransport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etatstransport>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne -> couche service -> couche web (Controller)
 */

class  EtatTransportRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etatstransport::class);
    }

    public function getEtatTransportBy_id()
    {
       
    }
  
}