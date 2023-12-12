<?php

namespace App\Service;

use App\Entity\Transport\CdeMatEnt;
use App\Repository\Depot\DepotRepository;
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
    public function __construct(ParameterBagInterface $params, private CdeMatEntRepository $cdeMatEntRepository, private DepotRepository $depotRepository)
    {
        $this->params = $params;
    }

    // service qui fait importation commande windec soit save soit update sur databases

    public function importationCommandeWindecParIdCommande($numCloud):string
    {
        try {

            $json = file_get_contents("https://cloud.layher.fr/get/" . $numCloud);
            $data = json_decode($json);
            $codeChantier = $data->m_clAdresse->m_stInformations->sCode_Analytique; //20143 si pour dépôt Lagny
            
            $depot = $this->depotRepository->findOneByCodedepot($codeChantier);

            $cdeMatEnt = $this->cdeMatEntRepository->commandeByNumeroCloud($numCloud) ?? new CdeMatEnt();
          
            $cdeMatEnt->setNumDevis(intval($data->m_clAdresse->m_stInformations->sNumeroDevis) ?? 0);
            $cdeMatEnt->setIdClient(0);
            $cdeMatEnt->setNomClient($data->m_clAdresse->m_sNom_client ?? 'DefaultNomClient');
            $cdeMatEnt->setCodeChantier(intval($data->m_clAdresse->m_sInstructionsSupplementaires) ?? 1);
            $cdeMatEnt->setNumAffaire($data->m_clAdresse->m_sInstructionsSupplementaires ?? 'DefaultNumAffaire');
            $cdeMatEnt->setAdresseChantier(($data->m_clAdresse->m_sAdresse_1 ?? '') . " " . ($data->m_clAdresse->m_sAdresse_2 ?? '') . " " . ($data->m_clAdresse->m_sAdresse_3 ?? ''));
            $cdeMatEnt->setCpChantier($data->m_clAdresse->m_sCode_postal ?? 'DefaultCodePostal');
            $cdeMatEnt->setVilleChantier($data->m_clAdresse->m_sVille ?? 'DefaultVille');
            $cdeMatEnt->setCommentaires($data->m_clAdresse->m_sCommentaires ?? 'Some comments');
            $dateString = $data->m_clAdresse->m_stInformations->dDate_decompte ?? '2023-01-01';
            $dateTime = \DateTime::createFromFormat('Y-m-d', $dateString);
            $cdeMatEnt->setDateCde($dateTime ?? new \DateTime('2023-01-01')); 
            
            $dateString = $data->m_clAdresse->m_stInformations->dDate_decompte ?? '2023-01-01'; 
            $year = substr($dateString, 0, 4);
            $month = substr($dateString, 5, 2);
            $day = substr($dateString, 8, 2);
            $DateCdeInv = $year . $month . $day;
            $cdeMatEnt->setDateCdeInv($DateCdeInv ?? 'DefaultDateCdeInv');
            $cdeMatEnt->setInitiales($data->m_clAdresse->m_stInformations->sInitiales ?? 'DefaultInitiales');
            $cdeMatEnt->setIdAgence($data->m_clAdresse->m_stInformations->sIdAgence ?? 4);
            $cdeMatEnt->setIddepot($depot ?? 'DefaultDepot');
            $cdeMatEnt->setNumEchange(intval($data->m_clAdresse->m_stInformations->sNumero_commande) ?? 0);
            $cdeMatEnt->setNumCloud(intval($numCloud) ?? 0);
            $cdeMatEnt->setPoidsTotMat($data->xPoidsTotal ?? 0.0);
            $cdeMatEnt->setValidationLayher($data->m_clAdresse->m_stInformations->bValidationLayher ?? false);
            $cdeMatEnt->setValidationJ4R($data->m_clAdresse->m_stInformations->bValidationJ4R ?? false);
            $cdeMatEnt->setCdeValide($data->m_clAdresse->m_stInformations->bCdeValide ?? 1);
            
            $this->cdeMatEntRepository->save($cdeMatEnt);
            return "succes";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
