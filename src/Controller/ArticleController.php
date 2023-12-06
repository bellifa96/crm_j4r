<?php

namespace App\Controller;

use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\DepotRepository;
use App\Service\DepotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
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


    #[Route('/articles', name: 'app_article')]
    public function index(): Response
    {
        $depots = $this->depotRepository->getAllDepot();

        //$this->depotService->article_layher_parser_file_xsl("Table m_tabArticle.xlsx",$depots);
        if (!empty($depots)) {
            $firstDepot = $depots[1];
            $articles = $this->articleRepository->findAllbyIdDepot($firstDepot["iddepot"]);

        } else {
            $articles = array();
        }

        return $this->render('article/index.html.twig', [
            'controller_name' => 'DepotController',
            'title' => 'Dépot',
            'depots' => $depots,
            'articles'=> $articles,
            'nav' => []
        ]);
    }
    #[Route('/get-article', name: 'app_article_depot', methods:['get'] )]
    public function getDepotAction(Request $request):JsonResponse
    { 
       $id_depot = $request->query->get('selectedDepot');
       $articles = $this->articleRepository->findAllbyIdDepotoptimiser($id_depot);
       return $this->json($articles);
    }





}
