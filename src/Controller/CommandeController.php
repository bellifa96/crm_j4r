<?php

namespace App\Controller;

use App\Repository\Depot\AgenceRepository;
use App\Repository\Transport\CdeMatEntRepository;
use App\Service\CommandeService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    private $agenceRepository;
   

    public function __construct(AgenceRepository $agenceRepository,private CommandeService $commandeService,private CdeMatEntRepository $cdeMatEntRepository)
    {
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
    #[Route('/search-commande/{id}', name: 'app_commande_search')]
    public function search_commande_save_update($id,Request $request)
    {
        try {
           $this->commandeService->importationCommandeWindecParIdCommande($id);

        } catch (Exception $e) {
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
          }
      }
}
