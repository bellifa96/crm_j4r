<?php

namespace App\Controller\Interlocuteur;

use App\Entity\Interlocuteur\Activite;
use App\Form\Interlocuteur\ActiviteType;
use App\Repository\Interlocuteur\ActiviteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/interlocuteur/activite')]
class ActiviteController extends AbstractController
{
    #[Route('/', name: 'app_interlocuteur_activite_index', methods: ['GET'])]
    public function index(ActiviteRepository $activiteRepository): Response
    {
        return $this->render('interlocuteur/activite/index.html.twig', [
            'activites' => $activiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_interlocuteur_activite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActiviteRepository $activiteRepository): Response
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activiteRepository->add($activite);
            return $this->redirectToRoute('app_interlocuteur_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interlocuteur/activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_interlocuteur_activite_show', methods: ['GET'])]
    public function show(Activite $activite): Response
    {
        return $this->render('interlocuteur/activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_interlocuteur_activite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activite $activite, ActiviteRepository $activiteRepository): Response
    {
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activiteRepository->add($activite);
            return $this->redirectToRoute('app_interlocuteur_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interlocuteur/activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_interlocuteur_activite_delete', methods: ['POST'])]
    public function delete(Request $request, Activite $activite, ActiviteRepository $activiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            $activiteRepository->remove($activite);
        }

        return $this->redirectToRoute('app_interlocuteur_activite_index', [], Response::HTTP_SEE_OTHER);
    }
}
