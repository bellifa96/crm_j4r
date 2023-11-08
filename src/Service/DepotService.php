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
        $fileData = $this->params->get('kernel.project_dir') . '/public/data/' . $file;
        $spreadsheet = IOFactory::load($fileData);
        $feuille = $spreadsheet->getActiveSheet();
        $donnees = $feuille->toArray();

        $articles = []; // Tableau pour stocker les articles

        foreach ($donnees as $ligne) {
            $articleData = [
                'Article' => '',
                'Designation' => '',
                'Poids' => 0,
                'PrixVente' => 0,
                'PrixLoc' => 0,
                'vente' => 0,
                'location' => 0,
            ];

            foreach ($ligne as $cellule) {
                if (empty($articleData['Article']) && $cellule !== 'Code article') {
                    $articleData['Article'] = $cellule;
                } elseif (empty($articleData['Designation']) && $cellule !== 'Désignation') {
                    $articleData['Designation'] = $cellule;
                } elseif ($articleData['Poids'] === 0 && $cellule !== 'Poids (kg)') {
                    $articleData['Poids'] = (float) $cellule;
                } elseif ($articleData['PrixVente'] === 0 && $cellule !== 'Prix Vente') {
                    $articleData['PrixVente'] = (float) $cellule;
                    $articleData['vente'] = $articleData['PrixVente'] > 0 ? 1 : 0;
                } elseif ($articleData['PrixLoc'] === 0 && $cellule !== 'Location Mensuelle') {
                    $articleData['PrixLoc'] = (float) $cellule;
                    $articleData['location'] = $articleData['PrixLoc'] > 0 ? 1 : 0;
                }
            }

            $articles[] = $articleData;
        }

        $insertData = [];
        foreach ($depots as $depot) {
            $agence = $depot->getIdagence();
            foreach ($articles as $articleData) {
                $article = new Articles();
                $article->setArticle($articleData['Article']);
                $article->setDesignation($articleData['Designation']);
                $article->setPoids($articleData['Poids']);
                $article->setPrixvente($articleData['PrixVente']);
                $article->setPrixloc($articleData['PrixLoc']);
                $article->setDepot($depot);
                $article->setIdagence($agence);
                $article->setDateachat(new \DateTime('2023-11-08'));
                $article->setDateachatinv(null);
                $article->setOldprixl($articleData['PrixLoc']);
                $article->setOldprixv($articleData['PrixVente']);
                $article->setVente($articleData['vente']);
                $article->setLocation($articleData['location']);
                $insertData[] = $article;
            }
        }

        // Insérer les données dans la base de données
        $this->articlesRepository->addAll($insertData);
    }
}
