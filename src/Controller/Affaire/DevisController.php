<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Devis;
use App\Entity\Affaire\Lot;
use App\Entity\Affaire\Ouvrage;
use App\Entity\Affaire\SousLot;
use App\Entity\Demande;
use App\Form\Affaire\DevisType;
use App\Repository\Affaire\DevisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/devis')]
class DevisController extends AbstractController
{
    #[Route('/', name: 'app_affaire_devis_index', methods: ['GET'])]
    public function index(DevisRepository $devisRepository): Response
    {
        return $this->render('affaire/devis/index.html.twig', [
            'devis' => $devisRepository->findAll(),
            'title'=> 'Liste des devis',
            'nav'=> []
        ]);
    }

    #[Route('/new/{id}', name: 'app_affaire_devis_new', methods: ['GET', 'POST'])]
    public function new(Demande $demande,Request $request, DevisRepository $devisRepository): Response
    {

        $devi = new Devis();
        $lot = new Lot();
        $sousLot = new SousLot();
        $lot->addSousLot($sousLot);
        $ouvrage = new Ouvrage();
        $sousLot->addOuvrage($ouvrage);
        $devi->addLot($lot);
        $devi->setDemande($demande);
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $devisRepository->add($devi);
            return $this->redirectToRoute('app_affaire_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/devis/new.html.twig', [
            'devi' => $devi,
            'form' => $form,
            'demande'=> $demande,
            'title'=> 'Créer un nouveau devis',
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_devis_show', methods: ['GET'])]
    public function show(Devis $devi): Response
    {
        return $this->render('affaire/devis/show.html.twig', [
            'devi' => $devi,
            'title'=> 'Devis N° '.$devi->getId(),
            'nav'=> []
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_devis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devis $devi, DevisRepository $devisRepository): Response
    {

        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $devisRepository->add($devi);
            return $this->redirectToRoute('app_affaire_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/devis/edit.html.twig', [
            'devi' => $devi,
            'form' => $form,
            'title'=> 'Modifier le devis N° '.$devi->getId(),
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_devis_delete', methods: ['POST'])]
    public function delete(Request $request, Devis $devi, DevisRepository $devisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devi->getId(), $request->request->get('_token'))) {
            $devisRepository->remove($devi);
        }

        return $this->redirectToRoute('app_affaire_devis_index', [], Response::HTTP_SEE_OTHER);
    }
}
