<?php

namespace App\Controller;

use App\Entity\Depot\Transporteur;
use App\Form\Affaire\TransportType;
use App\Form\TransporteurType;
use App\Repository\Depot\CamionRepository;
use App\Repository\Depot\ChauffeursRepository;
use App\Repository\Depot\TransporteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransporteurController extends AbstractController
{

    public function __construct(private TransporteurRepository $transporteurRepository, private CamionRepository $camionRepository,
     private ChauffeursRepository $chauffeursRepository)
    {
    }

    #[Route('/transporteur', name: 'app_transporteur')]
    public function index(): Response
    {
        $transport = $this->transporteurRepository->findAll();

        return $this->render('transporteur/index.html.twig', [
            'controller_name' => 'TransporteurController',
            'transporteurs' => $transport,
            'title' => '',
            'nav' => []
        ]);
    }
    #[Route('/edit-transporteur/{id}', name: 'app_edit_transporteur')]
    public function edit_agence(Transporteur $tresp, Request $request): Response
    {


        $camions = $this->camionRepository->findCamionsByIdTransporteur($tresp->getIdtransporteur());
        $chauffeurs = $this->chauffeursRepository->getALLchauffeursbyIdTansporteurs($tresp->getIdtransporteur());
        $form = $this->createForm(TransporteurType::class, $tresp);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // on stock les  donnes

        }




        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('transporteur/edit.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Edit ',
            'camions' => $camions,
            'chauffeurs' => $chauffeurs,
            'nav' => [['app_agence', 'Agences']]
        ]);
    }
}
