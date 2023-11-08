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

        // Créez un tableau associatif pour mapper les colonnes aux numéros de colonne
        $columnMap = array_flip($donnees[0]);

        foreach ($donnees as $index => $ligne) {
            if ($index === 0) {
                // La première ligne est l'en-tête, ignorez-la
                continue;
            }

            $article = new Articles();
            $vente = 0;
            $location = 0;

            foreach ($ligne as $colonne => $cellule) {
                // Utilisez le mappage pour obtenir le nom de la colonne
                $nomColonne = $columnMap[$colonne];

                switch ($nomColonne) {
                    case 'Code article':
                        $article->setArticle($cellule);
                        break;

                    case 'Désignation':
                        $article->setDesignation($cellule);
                        break;

                    case 'Poids (kg)':
                        $article->setPoids($cellule);
                        break;

                    case 'Prix Vente':
                        $PrixVente = $cellule;
                        if ($PrixVente > 0) {
                            $vente = 1;
                        }
                        $article->setPrixvente($PrixVente);
                        break;

                    case 'Location Mensuelle':
                        $PrixLoc = $cellule;
                        if ($PrixLoc > 0) {
                            $location = 1;
                        }
                        $article->setPrixloc($PrixLoc);
                        break;
                }
            }

            foreach ($depots as $depot) {
                $agence = $depot->getIdagence();
                $article->setDepot($depot);
                $article->setIdagence($agence);
                $article->setDateachat(new \DateTime('2023-11-08'));
                $article->setDateachatinv(null);
                $article->setVente($vente);
                $article->setLocation($location);
                $this->articlesRepository->add($article);
            }
        }
    }
}
