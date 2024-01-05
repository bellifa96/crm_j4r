<?php

namespace App\Controller;

use App\Entity\Depot\Camions;
use App\Entity\Depot\Chauffeurs;
use App\Entity\Depot\Transporteur;
use App\Form\Affaire\TransportType;
use App\Form\CamionsType;
use App\Form\ChauffeurType;
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

    public function __construct(
        private TransporteurRepository $transporteurRepository,
        private CamionRepository $camionRepository,
        private ChauffeursRepository $chauffeursRepository
    ) {
    }

    #[Route('/transporteur', name: 'app_transporteur')]
    public function index(): Response
    {
        $transport = $this->transporteurRepository->findAll();

        return $this->render('transporteur/index.html.twig', [
            'controller_name' => 'TransporteurController',
            'transporteurs' => $transport,
            'title' => 'Transporteur',
            'nav' => []
        ]);
    }
    #[Route('/edit-transporteur/{id}', name: 'app_edit_transporteur')]
    public function edit_transporteur(Transporteur $tresp, Request $request): Response
    {


        $camions = $this->camionRepository->findCamionsByIdTransporteur($tresp->getIdtransporteur());
        $chauffeurs = $this->chauffeursRepository->getALLchauffeursbyIdTansporteurs($tresp->getIdtransporteur());
        $form = $this->createForm(TransporteurType::class, $tresp);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $tresp->setDatemodif();
            $this->transporteurRepository->addTransporteur($tresp);
            return $this->redirectToRoute("app_transporteur");
        }




        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('transporteur/edit.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Détails du transporteur',
            'camions' => $camions,
            'chauffeurs' => $chauffeurs,
            'id' => $tresp->getIdtransporteur(),
            'nav' => [['app_transporteur', 'Transporteurs']]
        ]);
    }

    #[Route('/add-chauffeur/{id}', name: 'add_chauffeurs')]
    public function add_chauffeur($id, Request $request): Response
    {


        $chauffeurs = new Chauffeurs();
        $transport = $this->transporteurRepository->findAll();
        $choices = [];
        // Add each choice to the list. The id's have to match correctly so the html choicetype will return the chosen id that then will be saved in the db.
        for ($i = 0; $i < count($transport); $i++) {
            $choices += [$transport[$i]["societe"] => $transport[$i]["idtransporteur"]];
        }
        $form = $this->createForm(ChauffeurType::class, $chauffeurs, [
            'transporteurs' => $choices, // Pass the Doctrine service to the form
            'selected' => $id
        ]);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $this->chauffeursRepository->addChauffeur($chauffeurs);
            return $this->redirectToRoute("app_transporteur");
        }

        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('transporteur/addChauffeur.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Ajouter Chauffeurs',
            'transport' => $transport,
            'nav' => [['app_transporteur', 'Transporteur']]
        ]);
    }
    #[Route('/edit-chauffeur/{id}', name: 'edit_chauffeurs')]
    public function edit_chauffeur(Chauffeurs $chauffeurs, Request $request): Response
    {


        $transport = $this->transporteurRepository->findAll();
        $choices = [];
        // Add each choice to the list. The id's have to match correctly so the html choicetype will return the chosen id that then will be saved in the db.
        for ($i = 0; $i < count($transport); $i++) {
            $choices += [$transport[$i]["societe"] => $transport[$i]["idtransporteur"]];
        }
        $form = $this->createForm(ChauffeurType::class, $chauffeurs, [
            'transporteurs' => $choices, // Pass the Doctrine service to the form
            'selected' => $chauffeurs->getIdtransporteur()

        ]);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $this->chauffeursRepository->addChauffeur($chauffeurs);
            return $this->redirectToRoute("app_transporteur");
        }

        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('transporteur/addChauffeur.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Modifier Chauffeur',
            'transport' => $transport,
            'nav' => [['app_transporteur', 'Transporteur']]
        ]);
    }

    #[Route('/add-camions/{id}', name: 'add_camions')]
    public function add_camions($id, Request $request): Response
    {


        $camions = new Camions();
        $transport = $this->transporteurRepository->findAll();
        $choices = [];
        // Add each choice to the list. The id's have to match correctly so the html choicetype will return the chosen id that then will be saved in the db.
        for ($i = 0; $i < count($transport); $i++) {
            $choices += [$transport[$i]["societe"] => $transport[$i]["idtransporteur"]];
        }
        $form = $this->createForm(CamionsType::class, $camions, [
            'transporteurs' => $choices, // Pass the Doctrine service to the form
            'selected' => $id

        ]);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $this->camionRepository->addCamions($camions);
            return $this->redirectToRoute("app_transporteur");
        }

        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('transporteur/addCamions.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Ajouter Camion',
            'transport' => $transport,
            'nav' => [['app_transporteur', 'Transporteur']]
        ]);
    }
    #[Route('/edit-camions/{id}', name: 'edit_camions')]
    public function edit_camions(Camions $camions, Request $request): Response
    {


        $transport = $this->transporteurRepository->findAll();
        $choices = [];
        // Add each choice to the list. The id's have to match correctly so the html choicetype will return the chosen id that then will be saved in the db.
        for ($i = 0; $i < count($transport); $i++) {
            $choices += [$transport[$i]["societe"] => $transport[$i]["idtransporteur"]];
        }
        $form = $this->createForm(CamionsType::class, $camions, [
            'transporteurs' => $choices, // Pass the Doctrine service to the form
            'selected' => $camions->getIdtransporteur()
        ]);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $this->camionRepository->addCamions($camions);
            return $this->redirectToRoute("app_transporteur");
        }

        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('transporteur/addCamions.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Modifier Camion',
            'transport' => $transport,
            'nav' => [['app_transporteur', 'Transporteur']]
        ]);
    }
}
