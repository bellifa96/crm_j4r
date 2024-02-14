<?php

namespace App\Controller;

use App\Entity\Depot\Articles;
use App\Form\ArticleType;
use App\Repository\Depot\AgenceRepository;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\DepotRepository;
use App\Repository\Depot\EtatEnCoursRepository;
use App\Service\DepotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{  

    private $agenceRepository;

    private $depotService;

    private $articleRepository;
    public function __construct(AgenceRepository $agenceRepository, DepotService $depotService, ArticleRepository $articleRepository,
    private EtatEnCoursRepository $etatEncoursRepository
    )
    {
        $this->agenceRepository = $agenceRepository;
        $this->depotService = $depotService;
        $this->articleRepository = $articleRepository;
    }


    #[Route('/articles', name: 'app_article')]
    public function index(): Response
    {
        $agences = $this->agenceRepository->findAll();

        //$this->depotService->article_layher_parser_file_xsl("Table m_tabArticle.xlsx",$depots);
      
        $articles = array();
        

        return $this->render('article/index.html.twig', [
            'controller_name' => 'DepotController',
            'title' => 'Stock articles',
            'agences' => $agences,
            'articles'=> $articles,
            'nav' => []
        ]);
    }
    #[Route('/get-article', name: 'app_article_depot')]
    public function getArticlebyDepot(Request $request):JsonResponse
    { 
       $id_depot = $request->query->get('selectedDepot');
       $articles = $this->articleRepository->findAllbyIdDepotoptimiser($id_depot);
       return $this->json($articles);
    }

    #[Route('/edit-article/{id}', name: 'app_article_edit' )]
    public function editArticle(Articles $article,Request $request)
    { 
        $form = $this->createForm(ArticleType::class,$article);

        // on traite la requete du formulaire
        $form->handleRequest($request);
 
        // on verifier la formulaire
        if($form->isSubmitted() && $form->isValid()){
            // on stock les  donnes
           $resulat = $this->articleRepository->add($article);
           if($resulat){
              $this->addFlash("success","l'article a été correctement modifiée");
              return $this->redirectToRoute("app_article");
           }else{

           }
        }
        // on Recupere les affaires
        $numaffaire = $this->etatEncoursRepository->getALLEtatEncoursbyactif();

        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('article/edit.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Modification Article',
            'affaires' => $numaffaire,

            'nav' => [['app_article', 'Articles']]
        ]);
    }





}
