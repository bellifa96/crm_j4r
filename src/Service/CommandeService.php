<?php

namespace App\Service;

use App\Repository\Transport\CdeMatEntRepository;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Depot Service inject Repository pour faire traitement métier
 * ici tu trouve toutes les régles metiér 
 * 
 */

class CommandeService
{

    private $params;
    

    // injection depandance par constructeur cette une methode
    public function __construct(ParameterBagInterface $params,private CdeMatEntRepository $cdeMatEntRepository)
    {
        $this->params = $params;
    }

    // service qui fait importation commande windec soit save soit update sur databases

    public function importationCommandeWindecParIdCommande($id){
        try{

            $json = file_get_contents("https://cloud.layher.fr/get/".$id);
            $data = json_decode($json);
            dd($data);

        }catch(Exception){
            
        }
    }

    
}
