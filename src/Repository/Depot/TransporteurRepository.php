<?php
// src/Repository/ArticleRepository.php

namespace App\Repository\Depot;

use App\Entity\Depot\Etatstransport;
use App\Entity\Depot\Transporteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Transporteur>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne -> couche service -> couche web (Controller)
 */

class  TransporteurRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transporteur::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('e')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function addTransporteur($transporteur)
    {
        try {
            $this->_em->persist($transporteur);
            $this->_em->flush();
            return true;
        } catch (Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }
    public function findTransporteurById($id)
    {
        try {
            return $this->createQueryBuilder('d')
            ->select('d') // Select only id and nomdepot fields
            ->andWhere('d.idtransporteur = :idtransporteur')  // Corrected to provide a condition
            ->setParameter('idtransporteur', $id)
            ->getQuery()
            ->getOneOrNullResult();
        } catch (Exception $e) {
            // Gérer ou journaliser l'exception selon vos besoins
            dd($e->getMessage()); // dd est pour "dump and die", utilisé ici à des fins de débogage
            return null;
        }
    }
}
