<?php
// src/Repository/ArticleRepository.php

namespace App\Repository\Depot;

use App\Entity\Depot\Chauffeurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chauffeurs>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne -> couche service -> couche web (Controller)
 */

class ChauffeursRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chauffeurs::class);
    }

    public function getALLchauffeursbyIdTansporteurs($idTransporteur)
    {
        $etatsencours = $this->_em->createQueryBuilder()
        ->select('ch')
        ->from(Chauffeurs::class, 'ch')
        ->where('ch.actif = :actif')
        ->andWhere('ch.idtransporteur = :idTransporteur')
        ->setParameter('idTransporteur', $idTransporteur)
        ->setParameter('actif', 1)
        ->getQuery()
        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    return $etatsencours;
    }


  
}