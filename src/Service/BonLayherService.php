<?php

namespace App\Service;

use App\Repository\Depot\BonsdetailstempRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


/**
 * BonLayher Service inject Repository pour faire traitement métier
 * ici tu trouve toutes les régles metiér 
 * 
 */

class BonLayherService
{
    private $params;

    private $articlesRepository;


    public function __construct(ParameterBagInterface $params,private BonsdetailstempRepository $bonsdetailstempRepository )
    {
        $this->params = $params;
    }

    public function getBonLayherEntreDeuxDate($datedu,$date_au)
    {
        return$this->bonsdetailstempRepository->findByDateRange($datedu,$date_au);
    }
}
