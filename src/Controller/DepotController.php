<?php

namespace App\Controller;


use App\Entity\Depot\Agence;
use App\Entity\Depot\Articles;
use App\Entity\Depot\Depot;
use App\Form\DepotType;
use App\Repository\Depot\AgenceRepository;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\DepotRepository;
use App\Service\DepotService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    private $agenceRepository;

    
    public function __construct(DepotRepository $depotRepository,AgenceRepository $agenceRepository)
    {
        $this->depotRepository = $depotRepository;

        $this->agenceRepository = $agenceRepository;
       
    }


    #[Route('/depot', name: 'app_depot')]
    public function index(): Response
    {
      
        $agences = $this->agenceRepository->findAll();
        $depot = $this->depotRepository->getDepotsByAgenceId($agences[0]["idagence"]);

        return $this->render('depot/index.html.twig', [
            'controller_name' => 'AgenceController',
            'title' => 'Dépot',
            'depots' => $depot,
            'agences' => $agences,
            'nav' => []
        ]);
    }
    /** méthod pour afficher le formulaire et stocker les donées   */
    #[Route('/add-depot', name: 'app_depot_add')]
    public function add_agence(Request $request): Response
    {  

        // on crééer un "nouveau Agence"
        $Depot = new Depot();

        $form = $this->createForm(DepotType::class,$Depot);

        // on traite la requete du formulaire
        $form->handleRequest($request);
 
        // on verifier la formulaire
        if($form->isSubmitted() && $form->isValid()){
            // on stock les  donnes
           $resulat = $this->depotRepository->add_update_depot($Depot);
           if($resulat){
              $this->addFlash("success","Dépot a été correctement créer");
              return $this->redirectToRoute("app_depot");
           }else{

           }
        }
        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('depot/new.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Création un Dépot',
            'nav' => [['app_depot', 'Dépot']]
        ]);
          
    }
    #[Route('/edit-depot/{id}', name: 'app_depot_edit')]
    public function edit_agence(Depot $depot,Request $request): Response
    {  


        $form = $this->createForm(DepotType::class,$depot);

        // on traite la requete du formulaire
        $form->handleRequest($request);
 
        // on verifier la formulaire
        if($form->isSubmitted() && $form->isValid()){
            // on stock les  donnes
           $resulat = $this->depotRepository->add_update_depot($depot);
           if($resulat){
              $this->addFlash("success","Dépot a été correctement modifier");
              return $this->redirectToRoute("app_depot");
           }else{

           }
        }
        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('depot/edit.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Modification Dépot',
            'nav' => [['app_depot', 'Dépot']]
        ]);
          
    }

    #[Route('/get-depot', name: 'app_depot_json_response', methods:['get'] )]
    public function getDepotAction(Request $request):JsonResponse
    { 
       $id_agence = $request->query->get('selectedAgence');
       $depot = $this->depotRepository->getDepotsByAgenceId($id_agence);
       return $this->json($depot);
    }


    
}
