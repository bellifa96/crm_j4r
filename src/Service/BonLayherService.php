<?php

namespace App\Service;

use App\Repository\Depot\BonsdetailstempRepository;
use DateTime;
use Exception;
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


    public function __construct(ParameterBagInterface $params, private BonsdetailstempRepository $bonsdetailstempRepository)
    {
        $this->params = $params;
    }

    public function getBonLayherEntreDeuxDate($datedu, $date_au,$numaffaire)
    {
        $dateduObj = DateTime::createFromFormat('Y-m-d', $datedu);
        $dateAuObj = DateTime::createFromFormat('Y-m-d', $date_au);

        if (!$dateduObj || !$dateAuObj) {
            throw new Exception('Invalid date format');
        }

        $bons = $this->bonsdetailstempRepository->findByDateRange($numaffaire);

        $filteredBons = array_filter($bons, function ($bon) use ($dateduObj, $dateAuObj) {
            $bonDate = DateTime::createFromFormat('d/m/Y', $bon->getDatemvt());

            if (!$bonDate) {
                throw new Exception('Invalid date format in bon');
            }
            return ($bonDate >= $dateduObj && $bonDate <= $dateAuObj);
        });



        return $filteredBons;
    }
}