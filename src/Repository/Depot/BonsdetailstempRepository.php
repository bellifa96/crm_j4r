<?php
// src/Repository/ArticleRepository.php

namespace App\Repository\Depot;

use App\Entity\Depot\Bonsdetailstemp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bonsdetailstemp>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne -> couche service -> couche web (Controller)
 */

class BonsdetailstempRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bonsdetailstemp::class);
    }

    public function findByDateRange($numaffaire)
    {

        $res = $this->createQueryBuilder('b')
            ->where('b.numaffaire = :numaffaire')
            ->setParameter('numaffaire', $numaffaire)
            ->groupBy('b.numbon')
            ->getQuery()
            ->getResult();

        return $res;
    }
    public function getArticlebyNumero($numbon)
    {
        return $this->findBy(['numbon' => $numbon]);
    }
}