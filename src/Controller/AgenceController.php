<?php

namespace App\Controller;

use App\Entity\Depot\Agence;
use App\Form\AgenceType;
use App\Repository\Depot\AgenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgenceController extends AbstractController
{

    private $agenceRepository;


    public function __construct(AgenceRepository $agenceRepository)
    {
        $this->agenceRepository = $agenceRepository;
  
    }



    #[Route('/agence', name: 'app_agence')]
    public function index(): Response
    {  

        $agences = $this->agenceRepository->findAll();
        return $this->render('agence/index.html.twig', [
            'controller_name' => 'AgenceController',
            'title' => '',
            'agences' => $agences,
            'nav' => []
        ]);

          
    }
    /** méthod pour afficher le formulaire et stocker les donées   */
    #[Route('/add-agence', name: 'app_agence_add_agence')]
    public function add_agence(Request $request): Response
    {  

        // on crééer un "nouveau Agence"
        $agence = new Agence();

        $form = $this->createForm(AgenceType::class,$agence);

        // on traite la requete du formulaire
        $form->handleRequest($request);
 
        // on verifier la formulaire
        if($form->isSubmitted() && $form->isValid()){
            // on stock les  donnes
           $resulat = $this->agenceRepository->addAgence($agence);
           if($resulat){
              $this->addFlash("success","L'agence a été correctement créer");
              return $this->redirectToRoute("app_agence");
           }else{

           }
        }

     
        
       
        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('agence/new.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Création une Agence',
            'nav' => [['app_agence', 'Agences']]
        ]);

          
    }
    #[Route('/edit-agence/{id}', name: 'app_agence_edit_agence')]
    public function edit_agence(Agence $agence,Request $request): Response
    {  

        // on crééer un "nouveau Agence"

        $form = $this->createForm(AgenceType::class,$agence);

        // on traite la requete du formulaire
        $form->handleRequest($request);
 
        // on verifier la formulaire
        if($form->isSubmitted() && $form->isValid()){
            // on stock les  donnes
           $resulat = $this->agenceRepository->addAgence($agence);
           if($resulat){
              $this->addFlash("success","L'agence a été correctement modifiée");
              return $this->redirectToRoute("app_agence");
           }else{

           }
        }

     
        
       
        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('agence/edit.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Création une Agence',
            'nav' => [['app_agence', 'Agences']]
        ]);

          
    }


}
