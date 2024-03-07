<?php


namespace App\Repository\Depot;

use App\Entity\Affaire\Transport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Transport>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne
 */

class TransportRepository extends ServiceEntityRepository
{

    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Transport::class);

        $this->em = $entityManager;
    }
 
    public function add(Transport $mouvements)
    {
        $this->_em->persist($mouvements);

        $this->_em->flush();
        return true;
    }

   
}
