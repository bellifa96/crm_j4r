<?php
// src/Service/OutlookService.php
namespace App\Service;

use App\Entity\Depot\Mouvements;
use App\Repository\Depot\ArticleRepository;
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

    public function __construct(private ArticleRepository $articleRepository, private MouvementsRepository $mouvementsRepositroy)
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
                ->setDatemouvj4rinv(str_replace('-', '', $dateString))
                ->setDatemouv($dateObject)
                ->setDatemouvinv(str_replace('-', '', $dateString));

            // Set additional properties
            $mouvement
                ->setMvtvalide(true)
                ->setTypemouvj4r(6)
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
    }
    // regul - pour depot lagny
    public function regulLagnyMoins($data)
    {
    }

    // regul - pour depot layher
    public function regulLayherMoins($data)
    {
    }
}
