<?php

namespace App\Controller;


use App\Entity\Depot\Agence;
use App\Entity\Depot\Articles;
use App\Entity\Depot\Depot;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\DepotRepository;
use App\Service\DepotService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller Depot Inject Service (DepotService) et Repository ($ArticleRepositoy)
 * tu créer rien ici par rapport des requéte tous sur repository (pattern DAO)
 * 
 * 
 */

class DepotController extends AbstractController
{
    private $depotRepository;

    private $depotService;

    private $articleRepository;
    public function __construct(DepotRepository $depotRepository, DepotService $depotService, ArticleRepository $articleRepository)
    {
        $this->depotRepository = $depotRepository;
        $this->depotService = $depotService;
        $this->articleRepository = $articleRepository;
    }


    #[Route('/depot', name: 'app_depot')]
    public function index(): Response
    {
        $depots = $this->depotRepository->getAllDepot();

        //$this->depotService->article_layher_parser_file_xsl("Table m_tabArticle.xlsx",$depots);

        if (!empty($depots)) {
            $firstDepot = $depots[1];
            $articles = $this->articleRepository->findAllbyIdDepot($firstDepot->getIddepot());

        } else {
            $articles = array();
        }

        return $this->render('depot/index.html.twig', [
            'controller_name' => 'DepotController',
            'title' => 'Dépot',
            'depots' => $depots,
            'articles'=> null,
            'nav' => []
        ]);
    }
}
