<?php
// src/Repository/ArticleRepository.php

namespace App\Repository\Depot;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Depot\Articles;
use App\Entity\Depot\Camions;
use App\Entity\Depot\Depot;
use Exception;

/**
 * @extends ServiceEntityRepository<Camions>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne -> couche service -> couche web (Controller)
 */

class CamionRepository extends ServiceEntityRepository
{




    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Camions::class);
    }
    /**
     * Find camions by idTransporteur.
     *
     * @param int $idTransporteur
     * @return YourClassName[]|null
     */
    public function findCamionsByIdTransporteur($idTransporteur)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idtransporteur = :idTransporteur')
            ->setParameter('idTransporteur', $idTransporteur)
            ->getQuery()
            ->getResult();
    }
    public function addCamions(Camions $camions)
    {
        try {
            $this->_em->persist($camions);
            $this->_em->flush();
            return true;
        } catch (Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }
}
