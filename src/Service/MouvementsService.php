<?php
// src/Service/OutlookService.php
namespace App\Service;

use App\Controller\DepotController;
use App\Entity\Depot\Mouvements;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\DepotRepository;
use App\Repository\Depot\MouvementsRepository;
use App\Repository\Depot\ParamAgenceRepository;
use Exception;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
/* MouvementsService cette class pour traiter les mouvements 
**/

class MouvementsService
{

    public function __construct(private ArticleRepository $articleRepository, private MouvementsRepository $mouvementsRepositroy,private DepotRepository $depotRepository)
    {
    }


    public function regulPlusDepot($data)
    {
        if ($data["depot"]  == 11) {
            return $this->regulLayerPlus($data);
        } else {
            return  $this->regulLagnyPlus($data);
        }
    }

    public function regulMoinsDepot($data)
    {
        if ($data["depot"]  == 11) {
            return $this->regulLayherMoins($data);
        } else {
            return  $this->regulLagnyMoins($data);
        }
    }

    // regulPlus depot layher
    public function regulLayerPlus($data)
    {

        try {


            //get article 
            // Find the article by its ID
            $article = $this->articleRepository->findArticleByIdArticle($data["idArticle"]);

            // Ensure that the article is found
            if (!$article) {
                throw new \Exception("Article not found for ID: " . $data["idArticle"]);
            }

            $article = $article[0];

            // Create a new Mouvements instance
            $mouvement = new Mouvements();

            // Set properties of the Mouvements instance
            $mouvement
                ->setIdagence($article->getIdagence())
                ->setIddepot($article->getDepot())
                ->setNumaffaire($data["numAffaire"])
                ->setQtelocj4r($data["quantite"])
                ->setCommentaires($data["motif"])
                ->setPrixloc($article->getPrixloc())
                ->setPrixvente($article->getPrixvente())
                ->setSens(9)
                ->setArticle($article->getArticle());

            // Parse and set date properties
            $dateString = $data["date"];
            $dateObject = new \DateTime($dateString);
            $mouvement
                ->setDatemouvj4r($dateObject)
                ->setDatemouvj4rinv(str_replace('-', '', $dateString));

            $currentDate = new \DateTime();

            $mouvement->setDatemouv($currentDate);

            $currentDateWithoutHyphens = $currentDate->format('Ymd');

            $mouvement->setDatemouvinv($currentDateWithoutHyphens);

            // Set additional properties
            $mouvement
                ->setMvtvalide(true)
                ->setTypemouvj4r(5)
                ->setNumdevis(0)
                ->setIndice(0)
                ->setCodechantier($article->getDepot()->getCodechantier());


            // Update article quantity
            $article->setQtetotale($article->getQtetotale() + $data["quantite"]);


            // Persist the Mouvements entity
            $this->mouvementsRepositroy->add($mouvement);



            // Persist the updated article entity
            $this->articleRepository->add($article);

            return 200;
        } catch (Exception $exception) {
            dd($exception->getMessage());
            return 500;
        }
    }


    // regul + pour depot lagny
    public function regulLagnyPlus($data)
    {
        try {


            //get article 
            // Find the article by its ID
            $article = $this->articleRepository->findArticleByIdArticle($data["idArticle"]);

            // Ensure that the article is found
            if (!$article) {
                throw new \Exception("Article not found for ID: " . $data["idArticle"]);
            }

            $article = $article[0];

            // Create a new Mouvements instance
            $mouvement = new Mouvements();

            // Set properties of the Mouvements instance
            $mouvement
                ->setIdagence($article->getIdagence())
                ->setIddepot($article->getDepot())
                ->setNumaffaire($data["numAffaire"])
                ->setQtelocj4r($data["quantite"])
                ->setCommentaires($data["motif"])
                ->setPrixloc($article->getPrixloc())
                ->setPrixvente($article->getPrixvente())
                ->setSens(9)
                ->setArticle($article->getArticle());

            // Parse and set date properties
            $dateString = $data["date"];
            $dateObject = new \DateTime($dateString);
            $mouvement
                ->setDatemouvj4r($dateObject)
                ->setDatemouvj4rinv(str_replace('-', '', $dateString));
            $currentDate = new \DateTime();

            $mouvement->setDatemouv($currentDate);

            $currentDateWithoutHyphens = $currentDate->format('Ymd');

            $mouvement->setDatemouvinv($currentDateWithoutHyphens);

            // Set additional properties
            $mouvement
                ->setMvtvalide(true)
                ->setTypemouvj4r(5)
                ->setNumdevis(0)
                ->setIndice(0)
                ->setCodechantier($article->getDepot()->getCodechantier());


            $res = $this->depotRepository->getDepotsByAgenceId_CodeChantier($article->getIdagence(),1);

            $idDepotLayher = $res[0]["iddepot"];


            $this->articleRepository->updateQteTotaleLayherPlus($article->getIdagence(), $idDepotLayher, $data["quantite"]);

            // Update article quantity quatite autre depote 


            $article->setQtedispo($article->getQtedispo() + $data["quantite"]);


            // Persist the Mouvements entity
            $this->mouvementsRepositroy->add($mouvement);



            // Persist the updated article entity
            $this->articleRepository->add($article);

            return 200;
        } catch (Exception $exception) {
            dd($exception->getMessage());
            return 500;
        }
    }
    // regul - pour depot lagny
    public function regulLagnyMoins($data)
    {
        try {


            //get article 
            // Find the article by its ID
            $article = $this->articleRepository->findArticleByIdArticle($data["idArticle"]);

            // Ensure that the article is found
            if (!$article) {
                throw new \Exception("Article not found for ID: " . $data["idArticle"]);
            }

            $article = $article[0];

            // Create a new Mouvements instance
            $mouvement = new Mouvements();

            // Set properties of the Mouvements instance
            $mouvement
                ->setIdagence($article->getIdagence())
                ->setIddepot($article->getDepot())
                ->setNumaffaire($data["numAffaire"])
                ->setQtelocj4r($data["quantite"])
                ->setCommentaires($data["motif"])
                ->setPrixloc($article->getPrixloc())
                ->setPrixvente($article->getPrixvente())
                ->setSens(9)
                ->setArticle($article->getArticle());

            // Parse and set date properties
            $dateString = $data["date"];
            $dateObject = new \DateTime($dateString);
            $mouvement
                ->setDatemouvj4r($dateObject)
                ->setDatemouvj4rinv(str_replace('-', '', $dateString));
            $currentDate = new \DateTime();

            $mouvement->setDatemouv($currentDate);

            $currentDateWithoutHyphens = $currentDate->format('Ymd');

            $mouvement->setDatemouvinv($currentDateWithoutHyphens);

            // Set additional properties
            $mouvement
                ->setMvtvalide(true)
                ->setTypemouvj4r(6)
                ->setNumdevis(0)
                ->setIndice(0)
                ->setCodechantier($article->getDepot()->getCodechantier());

                $res = $this->depotRepository->getDepotsByAgenceId_CodeChantier($article->getIdagence(),1);

                $idDepotLayher = $res[0]["iddepot"];
    
    
                $this->articleRepository->updateQteTotaleLayherMoins($article->getIdagence(), $idDepotLayher,$data["quantite"]);

            // Update article quantity enlever quantite sur layher

            $article->setQtedispo($article->getQtedispo() - $data["quantite"]);


            // Persist the Mouvements entity
            $this->mouvementsRepositroy->add($mouvement);



            // Persist the updated article entity
            $this->articleRepository->add($article);

            return 200;
        } catch (Exception $exception) {
            dd($exception->getMessage());
            return 500;
        }
    }

    // regul - pour depot layher
    public function regulLayherMoins($data)
    {
        try {


            //get article 
            // Find the article by its ID
            $article = $this->articleRepository->findArticleByIdArticle($data["idArticle"]);

            // Ensure that the article is found
            if (!$article) {
                throw new \Exception("Article not found for ID: " . $data["idArticle"]);
            }

            $article = $article[0];

            // Create a new Mouvements instance
            $mouvement = new Mouvements();

            // Set properties of the Mouvements instance
            $mouvement
                ->setIdagence($article->getIdagence())
                ->setIddepot($article->getDepot())
                ->setNumaffaire($data["numAffaire"])
                ->setQtelocj4r($data["quantite"])
                ->setCommentaires($data["motif"])
                ->setPrixloc($article->getPrixloc())
                ->setPrixvente($article->getPrixvente())
                ->setSens(9)
                ->setArticle($article->getArticle());

            // Parse and set date properties
            $dateString = $data["date"];
            $dateObject = new \DateTime($dateString);
            $mouvement
                ->setDatemouvj4r($dateObject)
                ->setDatemouvj4rinv(str_replace('-', '', $dateString));
            $currentDate = new \DateTime();

            $mouvement->setDatemouv($currentDate);

            $currentDateWithoutHyphens = $currentDate->format('Ymd');

            $mouvement->setDatemouvinv($currentDateWithoutHyphens);

            // Set additional properties
            $mouvement
                ->setMvtvalide(true)
                ->setTypemouvj4r(6)
                ->setNumdevis(0)
                ->setIndice(0)
                ->setCodechantier($article->getDepot()->getCodechantier());


            // Update article quantity
            $article->setQtetotale($article->getQtetotale() - $data["quantite"]);


            // Persist the Mouvements entity
            $this->mouvementsRepositroy->add($mouvement);



            // Persist the updated article entity
            $this->articleRepository->add($article);

            return 200;
        } catch (Exception $exception) {
            dd($exception->getMessage());
            return 500;
        }
    }

    public function pertes_chantier($data){

    }
    public function pertes_stock_layher($data){
        
    }
    public function pertes_stock_lagny($data){
        
    }

    public function vol_chantier($data){
        
    }
    public function vol_depot_layher($data){
        
    }
    public function vol_depot_lagny($data){
        
    }

    public function materiel_HS_chantier($data){
        
    }
    public function materiel_HS_depot_layher($data){
        
    }
    public function materiel_HS_depot_lagny($data){
        
    }
    public function gains_chantier($data){
        
    }

    public function gains_depot($data){
        
    }



}
