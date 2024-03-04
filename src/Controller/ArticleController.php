<?php

namespace App\Controller;

use App\Entity\Depot\Articles;
use App\Form\ArticleType;
use App\Repository\Depot\AgenceRepository;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\ChantiersRepository;
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
    public function __construct(
        AgenceRepository $agenceRepository,
        DepotService $depotService,
        ArticleRepository $articleRepository,
        private EtatEnCoursRepository $etatEncoursRepository,
        private ChantiersRepository $chantiersRepository
    ) {
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
            'articles' => $articles,
            'nav' => []
        ]);
    }
    #[Route('/get-article', name: 'app_article_depot')]
    public function getArticlebyDepot(Request $request): JsonResponse
    {
        $id_depot = $request->query->get('selectedDepot');
        $articles = $this->articleRepository->findAllbyIdDepotoptimiser($id_depot);
        return $this->json($articles);
    }

    #[Route('/edit-article/{id}', name: 'app_article_edit')]
    public function editArticle(Articles $article, Request $request)
    {

        // récuperer chantier 

        $chantiers_by_agence = $this->chantiersRepository->getAllChantiersbyAgence($article->getIdagence());


        // contraint sur affichage des champs chaque type du depot depot codeDEPOT = 1 = layher
        $show = true;
        if ($article->getDepot()->getCodedepot() == 1) {
            $show = false;
        }

        $form = $this->createForm(ArticleType::class, $article, [
            'show' => $show, // Pass the Doctrine service to the form
        ]);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // on stock les  donnes
            $resulat = $this->articleRepository->add($article);
            if ($resulat) {
                $this->addFlash("success", "l'article a été correctement modifiée");
                return $this->redirectToRoute("app_article");
            } else {
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
            'show' => $show,
            'chantiers' => $chantiers_by_agence,
            'article' => $article->getIdarticles(),
            'nav' => [['app_article', 'Articles']]
        ]);
    }
}
