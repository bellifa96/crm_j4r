<?php

namespace App\Controller;

use App\Entity\Transport\CdeMatEnt;
use App\Form\CommandeType;
use App\Repository\Depot\AgenceRepository;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\DepotRepository;
use App\Repository\Transport\CdeMatDetRepository;
use App\Repository\Transport\CdeMatEntRepository;
use App\Service\CommandeService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    private $agenceRepository;

    public function __construct(
        AgenceRepository $agenceRepository,
        private CommandeService $commandeService,
        private CdeMatEntRepository $cdeMatEntRepository,
        private CdeMatDetRepository $cdeMatDetRepository,
        private DepotRepository $depotRepository,
        private ArticleRepository $articleRepository
    ) {
        $this->agenceRepository = $agenceRepository;
    }


    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {
        $agences = $this->agenceRepository->findAll();
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            'title' => '',
            'agences' => $agences,
            'nav' => []
        ]);
    }

    /** méthod pour afficher le formulaire et stocker les donées   */
    #[Route('/search-commande', name: 'app_commande_search')]
    public function search_commande_save_update(Request $request)
    {
        try {
            $numCloud = $request->query->get('numCloud');
            $reponse = $this->commandeService->importationCommandeWindecParIdCommande($numCloud);
            if ($reponse == 200) {
                $data = [
                    'message' => 'La commande a bien été chargée',
                    'code' => 200
                ];
                return new JsonResponse($data);
            } else if ($reponse == 500) {
                $data = [
                    'message' => "error sur serveur",
                    'code' => 500
                ];
                return new JsonResponse($data);
            } else {
                $data = [
                    'message' => "La commande est introuvable",
                    'code' => 500
                ];
                return new JsonResponse($data);
            }
        } catch (Exception $e) {
            return $this->json([]);
        }
    }

    /** méthod pour afficher le formulaire et stocker les donées   */
    #[Route('/get-commande', name: 'app_command_depot')]
    public function getCommandeByIdDepot(Request $request)
    {
        try {
            $id_depot = $request->query->get('selectedDepot');
            $articles = $this->cdeMatEntRepository->listCommandebyIdepot($id_depot);
            return $this->json($articles);
        } catch (Exception $e) {

            return $this->json([]);
        }
    }

    /** méthod pour afficher le detail commande */
    #[Route('/edit-commande/{id}', name: 'edit_commande')]
    public function affiche_commande(CdeMatEnt $cdeMatEnt, Request $request)
    {
        $depots = null;
        try {
            $articles = $this->cdeMatDetRepository->articles_by_cde($cdeMatEnt->getId());
            $articlesbyDepot = $this->articleRepository->findAll_article_désignation_byIdDepot($cdeMatEnt->getIddepot());
            $depots = $this->depotRepository->findOneByIdDepot($cdeMatEnt->getIddepot());
            $form = $this->createForm(CommandeType::class, $cdeMatEnt);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $resulat = $this->cdeMatEntRepository->save($cdeMatEnt);
                if($resulat){
                   $this->addFlash("success","l'article a été correctement modifiée");
                }else{
     
                }
            }
            return $this->render('commande/edit.html.twig', [
                'ticket' => null,
                'form' => $form->createView(),
                'title' => 'Modification Commande',
                'nav' => [['app_commande', 'Commande']],
                'articles' => $articles,
                'depots' => $depots,
                'articlesbyDepot' =>$articlesbyDepot,
                'idCdeEnte' => $cdeMatEnt->getId()
            ]);
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /** méthod modifier les qtes articles   */
    #[Route('/update-qte-article', name: 'app_qte_article')]
    public function update_qte_article(Request $request)
    {
        try {
            $qtes = json_decode($request->getContent(), true);
            $reponse = $this->commandeService->update_qte_sortie($qtes);
            if ($reponse == 200) {
                $data = [
                    'message' => 'La quantité a bien été modifier',
                    'code' => 200
                ];
                return new JsonResponse($data);
            } else if ($reponse == 500) {
                $data = [
                    'message' => "error sur serveur",
                    'code' => 500
                ];
                return new JsonResponse($data);
            } else {
                $data = [
                    'message' => "La quantité est introuvable",
                    'code' => 500
                ];
                return new JsonResponse($data);
            }
        } catch (Exception $e) {

            return $this->json([]);
        }
  
    }
}