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

    public function findByDateRange($startDate, $endDate)
    {
        $startDateString = '10/12/2023';
        $endDateString = '30/12/2023';

        $startDate = \DateTime::createFromFormat('d/m/Y', $startDateString);
        $endDate = \DateTime::createFromFormat('d/m/Y', $endDateString);

        // Check if date objects were created successfully
        if ($startDate instanceof \DateTime && $endDate instanceof \DateTime) {
            $formattedStartDate = $startDate->format('Y-m-d');
            $formattedEndDate = $endDate->format('Y-m-d');

            $query = $this->createQueryBuilder('b')
                ->where('b.datemvt BETWEEN :start_date AND :end_date')
                ->setParameter('start_date', $formattedStartDate)
                ->setParameter('end_date', $formattedEndDate)
                ->getQuery();

            $results = $query->getResult();
            
           return $results;
            // Handle $results as needed
        } else {
            // Handle error if date objects couldn't be created
            echo "Error creating DateTime objects";
        }
    }
    public function getArticlebyNumero($numbon)
    {
        return $this->findBy(['numbon' => $numbon]);
    }
}
