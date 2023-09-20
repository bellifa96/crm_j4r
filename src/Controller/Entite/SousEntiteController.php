<?php

namespace App\Controller\Entite;

use App\Entity\Entite\SousEntite;
use App\Form\Entite\SousEntiteType;
use App\Repository\Entite\SousEntiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/entite/sous/entite')]
class SousEntiteController extends AbstractController
{
    #[Route('/', name: 'app_entite_sous_entite_index', methods: ['GET'])]
    public function index(SousEntiteRepository $sousEntiteRepository): Response
    {
        return $this->render('entite/sous_entite/index.html.twig', [
            'sous_entites' => $sousEntiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_entite_sous_entite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SousEntiteRepository $sousEntiteRepository): Response
    {
        $sousEntite = new SousEntite();
        $form = $this->createForm(SousEntiteType::class, $sousEntite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sousEntiteRepository->add($sousEntite);
            return $this->redirectToRoute('app_entite_sous_entite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entite/sous_entite/new.html.twig', [
            'sous_entite' => $sousEntite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entite_sous_entite_show', methods: ['GET'])]
    public function show(SousEntite $sousEntite): Response
    {
        return $this->render('entite/sous_entite/show.html.twig', [
            'sous_entite' => $sousEntite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entite_sous_entite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SousEntite $sousEntite, SousEntiteRepository $sousEntiteRepository): Response
    {
        $form = $this->createForm(SousEntiteType::class, $sousEntite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sousEntiteRepository->add($sousEntite);
            return $this->redirectToRoute('app_entite_sous_entite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entite/sous_entite/edit.html.twig', [
            'sous_entite' => $sousEntite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entite_sous_entite_delete', methods: ['POST'])]
    public function delete(Request $request, SousEntite $sousEntite, SousEntiteRepository $sousEntiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sousEntite->getId(), $request->request->get('_token'))) {
            $sousEntiteRepository->remove($sousEntite);
        }

        return $this->redirectToRoute('app_entite_sous_entite_index', [], Response::HTTP_SEE_OTHER);
    }
}
