<?php

namespace App\Controller\Entite;

use App\Entity\Entite\Entite;
use App\Form\Entite\EntiteType;
use App\Repository\Entite\EntiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/entite/entite')]
class EntiteController extends AbstractController
{
    #[Route('/', name: 'app_entite_entite_index', methods: ['GET'])]
    public function index(EntiteRepository $entiteRepository): Response
    {
        return $this->render('entite/entite/index.html.twig', [
            'entites' => $entiteRepository->findAll(),
            'title'  => 'Entité',
        ]);
    }

    #[Route('/new', name: 'app_entite_entite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntiteRepository $entiteRepository): Response
    {
        $entite = new Entite();
        $form = $this->createForm(EntiteType::class, $entite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entiteRepository->add($entite);
            return $this->redirectToRoute('app_entite_entite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entite/entite/new.html.twig', [
            'entite' => $entite,
            'form' => $form,
            'title'  => 'Entité',
        ]);
    }

    #[Route('/{id}', name: 'app_entite_entite_show', methods: ['GET'])]
    public function show(Entite $entite): Response
    {
        return $this->render('entite/entite/show.html.twig', [
            'entite' => $entite,
            'title'  => 'Entité',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entite_entite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entite $entite, EntiteRepository $entiteRepository): Response
    {
        $form = $this->createForm(EntiteType::class, $entite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entiteRepository->add($entite);
            return $this->redirectToRoute('app_entite_entite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entite/entite/edit.html.twig', [
            'entite' => $entite,
            'form' => $form,
            'title'  => 'Entité',
        ]);
    }

    #[Route('/{id}', name: 'app_entite_entite_delete', methods: ['POST'])]
    public function delete(Request $request, Entite $entite, EntiteRepository $entiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entite->getId(), $request->request->get('_token'))) {
            $entiteRepository->remove($entite);
        }

        return $this->redirectToRoute('app_entite_entite_index', [], Response::HTTP_SEE_OTHER);
    }
}
