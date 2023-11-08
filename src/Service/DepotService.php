<?php

namespace App\Service;

use App\Entity\Depot\Articles;
use App\Repository\Depot\ArticleRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Depot Service inject Repository pour faire traitement métier
 * ici tu trouve toutes les régles metiér 
 * 
 */

class DepotService
{

    private $params;

    private $articlesRepository;


    public function __construct(ParameterBagInterface $params, ArticleRepository $articlesRepository)
    {
        $this->params = $params;
        $this->articlesRepository = $articlesRepository;
    }

    public function article_layher_parser_file_xsl($file, $depots)
    {

        //
        $fileData =    $this->params->get('kernel.project_dir') . '/public/data/' . $file;
        $spreadsheet = IOFactory::load($fileData);


        // Sélection de la première feuille de calcul (index 0)
        $feuille = $spreadsheet->getActiveSheet();

        // Récupération des données de la feuille de calcul sous forme de tableau
        $donnees = $feuille->toArray();

       
        foreach ($depots as $depot) {
            $agence = $depot->getIdagence();

            foreach ($donnees as $ligne) {
                $article = new Articles();
                $Compteur = 0;
                foreach ($ligne as $cellule) {
                    $Compteur++;
                    if ($Compteur == 1) {
                        if ($cellule != 'Code article') {
                            $Article = $cellule;
                            $RefFourn = $cellule;
                            $article->setArticle($Article);
                        }
                    }
                    if ($Compteur == 2) {
                        if ($cellule != 'Désignation') {

                            $Designation = $cellule;
                            $article->setDesignation($Designation);
                        }
                    }
                    if ($Compteur == 3) {
                        if ($cellule != 'Poids (kg)') {
                            $Poids = $cellule;
                            $article->setPoids($Poids);
                        }
                    }
                    if ($Compteur == 4) {
                        if ($cellule != 'Prix Vente') {
                            $PrixVente = $cellule;
                            if ($PrixVente > 0) {
                                $vente = 1;
                                $old_prix_v = $PrixVente;
                            } else {
                                $vente = 0;
                                $old_prix_v = 0;
                            }
                            $article->setPrixvente($PrixVente);
                        }
                    }
                    if ($Compteur == 5) {
                        if ($cellule != 'Location Mensuelle') {
                            $PrixLoc = $cellule;
                            if ($PrixLoc > 0) {
                                $location = 1;
                                $old_prix_l = $PrixLoc;
                            } else {
                                $location = 0;
                                $old_prix_l = 0;
                            }
                            $article->setPrixloc($PrixLoc);
                        }
                    }
                }
                $article->setDepot($depot);
                $article->setIdagence($agence);
                $article->setDateachat(new \DateTime('2023-11-08')); // Example date
                $article->setDateachatinv(null);
                $this->articlesRepository->add($article); // appel la method add in repository 
            }
        }
    }
}
