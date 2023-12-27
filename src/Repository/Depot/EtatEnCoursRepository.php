<?php
// src/Repository/ArticleRepository.php

namespace App\Repository\Depot;

use App\Entity\Depot\Etatsencours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etatsencours>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne -> couche service -> couche web (Controller)
 */

class EtatEnCoursRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etatsencours::class);
    }

    public function getALLEtatEncoursbyactif()
    {
        $etatsencours = $this->_em->createQueryBuilder()
        ->select('etatsencours.id', 'etatsencours.numaffaire')
        ->from(Etatsencours::class, 'etatsencours')
        ->where('etatsencours.actif = :actif')
        ->setParameter('actif', 1)
        ->getQuery()
        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    return $etatsencours;
    }

    public function findById($id)
    {
        $etatsencours = $this->_em->createQueryBuilder()
        ->select('etatsencours.nom')
        ->from(Etatsencours::class, 'etatsencours')
        ->where('etatsencours.actif = :actif')
        ->andWhere('etatsencours.id = :id')
        ->setParameter('actif', 1)
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    return $etatsencours;
    }
  
}