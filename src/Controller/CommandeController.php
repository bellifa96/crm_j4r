<?php

namespace App\Controller;

use App\Repository\Depot\AgenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
   private $agenceRepository;

   public function __construct(AgenceRepository $agenceRepository) {
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
     public function add_agence(Request $request): Response
     {  
 
         // on crééer un "nouveau Agence"
 
         $form = $this->createForm(AgenceType::class);
 
         // on traite la requete du formulaire
         $form->handleRequest($request);
  
         // on verifier la formulaire
         if($form->isSubmitted() && $form->isValid()){
             // on stock les  donnes
            $resulat = true;
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
}
