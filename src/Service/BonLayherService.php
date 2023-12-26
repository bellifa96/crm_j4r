<?php

namespace App\Service;

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


    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function getBonLayherEntreDeuxDate()
    {

        

    }
}
