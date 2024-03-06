<?php

namespace App\Controller;

use App\Entity\Depot\Chantiers;
use App\Form\ChantierType;
use App\Repository\Depot\AgenceRepository;
use App\Repository\Depot\ChantiersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/chantier')]
class ChantiersController extends AbstractController
{  

    public function __construct(
      private ChantiersRepository $chantiersRepository
      ,private AgenceRepository $agenceRepository
    ) {
    }


    #[Route('/', name: 'app_chantiers')]
    public function index(): Response
    { 
        $chantiers = $this->chantiersRepository->getAllChantiers();
        $agences = $this->agenceRepository->findAll();

        return $this->render('chantiers/index.html.twig', [
            'controller_name' => 'CommandeController',
            'title' => 'Chantiers',
            'agences' => $agences,
            'chantiers' => $chantiers,
            'nav' => []
        ]);
    }
    #[Route('/edit-chantier/{id}', name: 'edit_chantiers')]
    public function edit_chantier(Chantiers $chantier, Request $request): Response
    {


       
        $form = $this->createForm(ChantierType::class, $chantier);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $resulat = $this->chantiersRepository->add_update_depot($chantier);
            if ($resulat) {
                $this->addFlash("success", "Dépot a été correctement modifier");
                return $this->redirectToRoute("app_chantiers");
            } else {
            }
        }

        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('chantiers/new.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Modifier Chantiers',
            'nav' => [['app_chantiers', 'Chantiers']]
        ]);
    }


}
