<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Evenement;
use App\Entity\Demande;
use App\Form\Affaire\EvenementType;
use App\Repository\Affaire\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_affaire_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('affaire/evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'title' => 'Liste des tâches',
            'nav' => []
        ]);
    }

    #[Route('/new/{id}', name: 'app_affaire_evenement_new', methods: ['GET', 'POST'])]
    public function new(Demande $demande,Request $request, EvenementRepository $evenementRepository): Response
    {
        $evenement = new Evenement();
        $evenement->setCreateur($this->getUser());
        $demande->addEvenement($evenement);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->add($evenement);
            return $this->redirectToRoute('app_affaire_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
            'title' => 'Liste des tâches',
            'nav' => []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('affaire/evenement/show.html.twig', [
            'evenement' => $evenement,
            'title' => 'Liste des tâches',
            'nav' => []
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->add($evenement);
            return $this->redirectToRoute('app_affaire_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
            'title' => 'Liste des tâches',
            'nav' => []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $evenementRepository->remove($evenement);
        }

        return $this->redirectToRoute('app_affaire_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
