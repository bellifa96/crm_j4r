<?php

namespace App\Service;

use App\Entity\Transport\CdeMatDet;
use App\Entity\Transport\CdeMatEnt;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\ChantiersRepository;
use App\Repository\Depot\DepotRepository;
use App\Repository\Transport\CdeMatDetRepository;
use App\Repository\Transport\CdeMatEntRepository;
use App\Repository\UserRepository;
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
    public function __construct(
        ParameterBagInterface $params,
        private CdeMatEntRepository $cdeMatEntRepository,
        private DepotRepository $depotRepository,
        private CdeMatDetRepository $cdeMatDetRepository,
        private ArticleRepository $articleRepository,
        private ChantiersRepository $chantiersRepository,
        private UserRepository $userRepository,

        private OutlookService $outlookService,
    ) {
        $this->params = $params;
    }

    /* service qui fait importation commande windec soit save soit update sur databases on persist commande et les articles
     **/

    public function importationCommandeWindecParIdCommande($numCloud): int
    {
        try {

            $json = file_get_contents("https://cloud.layher.fr/get/" . $numCloud);
            if ($json == null) {
                return 401;
            }
            $data = json_decode($json);

            $codeChantier = $data->m_clAdresse->m_stInformations->sCode_Analytique; //20143 si pour dépôt Lagny

            $depot = $this->depotRepository->findOneByCodedepot($codeChantier);

            $cdeMatEnt = $this->cdeMatEntRepository->commandeByNumeroCloud($numCloud) ?? new CdeMatEnt();

            $cdeMatEnt->setNumDevis(intval($data->m_clAdresse->m_stInformations->sNumeroDevis) ?? 0);
            $cdeMatEnt->setIdClient(0);
            $cdeMatEnt->setNomClient($data->m_clAdresse->m_sNom_client ?? '');
            $cdeMatEnt->setCodeChantier(intval($data->m_clAdresse->m_sInstructionsSupplementaires) ?? 1);
            $cdeMatEnt->setNumAffaire($data->m_clAdresse->m_sInstructionsSupplementaires ?? '');
            $cdeMatEnt->setAdresseChantier(($data->m_clAdresse->m_sAdresse_1 ?? '') . " " . ($data->m_clAdresse->m_sAdresse_2 ?? '') . " " . ($data->m_clAdresse->m_sAdresse_3 ?? ''));
            $cdeMatEnt->setCpChantier($data->m_clAdresse->m_sCode_postal ?? '');
            $cdeMatEnt->setVilleChantier($data->m_clAdresse->m_sVille ?? '');
            $cdeMatEnt->setCommentaires($data->m_clAdresse->m_sCommentaires ?? '');
            $dateString = $data->m_clAdresse->m_stInformations->dDate_decompte ?? '2023-01-01';
            $dateTime = \DateTime::createFromFormat('Y-m-d', $dateString);
            $cdeMatEnt->setDateCde($dateTime ?? new \DateTime('2023-01-01'));

            $dateString = $data->m_clAdresse->m_stInformations->dDate_decompte ?? '2023-01-01';
            $year = substr($dateString, 0, 4);
            $month = substr($dateString, 5, 2);
            $day = substr($dateString, 8, 2);
            $DateCdeInv = $year . $month . $day;
            $cdeMatEnt->setDateCdeInv($DateCdeInv ?? '');
            $cdeMatEnt->setInitiales($data->m_clAdresse->m_stInformations->sInitiales ?? '');
            $cdeMatEnt->setIdAgence($data->m_clAdresse->m_stInformations->sIdAgence ?? 0);
            $cdeMatEnt->setIddepot($depot ?? '');
            $cdeMatEnt->setNumEchange(intval($data->m_clAdresse->m_stInformations->sNumero_commande) ?? 0);
            $cdeMatEnt->setNumCloud(intval($numCloud) ?? 0);
            $cdeMatEnt->setPoidsTotMat($data->xPoidsTotal ?? 0.0);
            $cdeMatEnt->setValidationLayher($data->m_clAdresse->m_stInformations->bValidationLayher ?? false);
            $cdeMatEnt->setValidationJ4R($data->m_clAdresse->m_stInformations->bValidationJ4R ?? false);
            $cdeMatEnt->setCdeValide($data->m_clAdresse->m_stInformations->bCdeValide ?? 1);
            $idCateEntre = $this->cdeMatEntRepository->save($cdeMatEnt);

            if ($data && isset($data->m_tabArticleLocation)) {


                $m_tabArticleLocation = $data->m_tabArticleLocation;
                foreach ($m_tabArticleLocation as $m_tabArticleLocation) {
                    $cde_mat_det = $this->cdeMatDetRepository->article_by_numCloud_id_typeMat($numCloud, $m_tabArticleLocation->sCodeArticle, "L") ?? new CdeMatDet();
                    $cde_mat_det->setNumLigne($m_tabArticleLocation->nNumero ?? 0);
                    $cde_mat_det->setArticle($m_tabArticleLocation->sCodeArticle ?? '');
                    $cde_mat_det->setDesignation($m_tabArticleLocation->sDesignation ?? '');
                    $cde_mat_det->setQte($m_tabArticleLocation->nQuantite ?? 0);
                    $cde_mat_det->setPoids($m_tabArticleLocation->xPoids ?? 0.0);
                    $cde_mat_det->setNumDevis(intval($data->m_clAdresse->m_stInformations->sNumeroDevis) ?? 0);
                    $cde_mat_det->setIdCdeMatEnt($idCateEntre);
                    $cde_mat_det->setTypeMat("L");
                    $cde_mat_det->setQteSortie(0);
                    $cde_mat_det->setCodeChantier(intval($data->m_clAdresse->m_sInstructionsSupplementaires) ?? 1);
                    $cde_mat_det->setNumCloud($numCloud);
                    $this->cdeMatDetRepository->save($cde_mat_det);
                }
            }


            if ($data && isset($data->m_tabArticleVente)) {
                $m_tabArticleVente = $data->m_tabArticleVente;
                foreach ($m_tabArticleVente as $m_tabArticleVente) {
                    $cde_mat_det = $this->cdeMatDetRepository->article_by_numCloud_id_typeMat($numCloud, $m_tabArticleVente->sCodeArticle, "V") ?? new CdeMatDet();


                    $cde_mat_det->setNumLigne($m_tabArticleVente->nNumero ?? 0);
                    $cde_mat_det->setArticle($m_tabArticleVente->sCodeArticle ?? '');
                    $cde_mat_det->setDesignation($m_tabArticleVente->sDesignation ?? '');
                    $cde_mat_det->setQte($m_tabArticleVente->nQuantite ?? 0);
                    $cde_mat_det->setPoids($m_tabArticleVente->xPoids ?? 0.0);
                    $cde_mat_det->setNumDevis(intval($data->m_clAdresse->m_stInformations->sNumeroDevis) ?? 0);
                    $cde_mat_det->setIdCdeMatEnt($idCateEntre);
                    $cde_mat_det->setTypeMat("V");
                    $cde_mat_det->setQteSortie(0);
                    $cde_mat_det->setCodeChantier(intval($data->m_clAdresse->m_sInstructionsSupplementaires) ?? 1);
                    $cde_mat_det->setNumCloud($numCloud);
                    $this->cdeMatDetRepository->save($cde_mat_det);
                }
            }
            return 200;
        } catch (Exception $e) {
            return 500;
        }
    }

    public function update_qte_sortie($data)
    {
        try {

            if (isset($data['articleQte']) && is_array($data['articleQte'])) {
                $depot = $this->depotRepository->findOneByCodedepot1($data['articleQte'][0]["idDepot"]);
                foreach ($data['articleQte'] as $item) {

                    $iddepot = $item['iddepot'];

                    $qteSortie = $item['qteSortie'];
                    $articles = $item['article'];
                    $cmdent  = $item['idCdeEnte'];
                    // modifier les articles qui exists déja 
                    if ($iddepot != 0) {
                        $this->cdeMatDetRepository->updateQteSortieById($iddepot, $qteSortie);
                    } else {
                        // on créer des articles 
                        $mat  = $item['mat'];
                        $cde_det = new CdeMatDet();
                        $article = $this->articleRepository->findAll_article_bydésignation($depot->getIddepot(), $articles);
                        $cde_det->setArticle($article["article"]);
                        $cde_det->setDesignation($article["designation"]);
                        $cde_det->setTypeMat($mat);
                        $cde_det->setQteSortie($qteSortie);
                        $cde_det->setIdCdeMatEnt($cmdent);
                        $cde_det->setNumDevis(0);
                        $cde_det->setCodeChantier(1000);
                        $cde_det->setQte(0);
                        $cde_det->setPoids($article["poids"]);
                        $cde_det->setNumLigne(0);
                        $cde_det->setNumCloud(0);
                        $this->cdeMatDetRepository->save($cde_det);
                    }
                    $this->articleRepository->updateQteReserverById($articles, $qteSortie, $depot);
                }
            } else {
                return 401;
            }
        } catch (Exception $exception) {
            return 500;
        }
        return 200;
    }

    public function save($formData, $article, $iddepot)
    {

        try {
            $depot = $this->depotRepository->findOneByCodedepot1($iddepot)->getIddepot();
            $chantier = $this->chantiersRepository->findByIdChantier($formData['commande']['chantier']);
            $condecteur = $this->userRepository->findByIdUser($formData['commande']['conducteur']);
            $commande = new CdeMatEnt();
            // Access nested DateCde values
            $commande->setDateCde(new \DateTime()); // This sets the date and time to the current date and time

            $dateEnlev = $formData['commande']['DateEnlevDem']; // Assuming $dateEnlev holds the date string

            // Convert the date string to a timestamp
            $timestamp = strtotime($dateEnlev);

            // Format the timestamp to display the date in a different format
            $dateObject = new  \DateTime($dateEnlev);
            $commande->setDateEnlevDem($dateObject);

            $timeString = $formData['commande']['HeureEnlevDem']; // Assuming $timeString holds the time string

            // Create a DateTime object using the time string
            $timeObject = \DateTime::createFromFormat('H:i', $timeString);
            $commande->setHeureEnlevDem($timeObject);
            $commande->setChantier($chantier);
            $commande->setConducteur($condecteur);

            $commande->setPoidsTotMat($formData['commande']['PoidsTotMat'] ?? '0.00');

            $commande->setIddepot($depot);
            $commande->setActif(true);
            $commande->setAdresseChantier($formData['commande']['adresse_chantier']);
            $commande->setCommentaires1($formData['commande']['Commentaires1']);
            $commande->setCommentaires2($formData['commande']['Commentaires2']);
            $commande->setNumEchange($formData['commande']['NumEchange']);
            $idCde = $this->cdeMatEntRepository->save($commande);
            $this->save_cde_det($article, $idCde, $depot);
            return 1;
        } catch (Exception $e) {
            dd($e->getMessage());
            return -1;
        }
    }

    public function save_cde_det($data, $id, $depot)
    {
        try {
            if (isset($data) && is_array($data)) {
                foreach ($data as $item) {


                    $qteSortie = $item["qteSortie"];
                    $articles = $item["article"];
                    // modifier les articles qui exists déja 

                    // on créer des articles 
                    $mat  = $item["mat"];
                    $cde_det = new CdeMatDet();
                    $article = $this->articleRepository->findAll_article_bydésignation($depot, $articles);
                    $cde_det->setArticle($article["article"]);
                    $cde_det->setDesignation($article["designation"]);
                    $cde_det->setTypeMat($mat);
                    $cde_det->setQteSortie($qteSortie);
                    $cde_det->setIdCdeMatEnt($id);
                    $cde_det->setNumDevis(0);
                    $cde_det->setCodeChantier(1000);
                    $cde_det->setQte(0);
                    $cde_det->setPoids($article["poids"]);
                    $cde_det->setNumLigne(0);
                    $cde_det->setNumCloud(0);
                    $this->cdeMatDetRepository->save($cde_det);
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
