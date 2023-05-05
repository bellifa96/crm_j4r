<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\AttributOuvrage;
use App\Form\Affaire\AttributOuvrageType;
use App\Repository\Affaire\AttributOuvrageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/attribut/ouvrage')]
class AttributOuvrageController extends AbstractController
{
    #[Route('/', name: 'app_affaire_attribut_ouvrage_index', methods: ['GET'])]
    public function index(AttributOuvrageRepository $attributOuvrageRepository): Response
    {
        return $this->render('affaire/attribut_ouvrage/index.html.twig', [
            'attribut_ouvrages' => $attributOuvrageRepository->findByIsTable(true),
        ]);
    }

    #[Route('/new', name: 'app_affaire_attribut_ouvrage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AttributOuvrageRepository $attributOuvrageRepository): Response
    {
        $attributOuvrage = new AttributOuvrage();
        $form = $this->createForm(AttributOuvrageType::class, $attributOuvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributOuvrageRepository->save($attributOuvrage, true);

            return $this->redirectToRoute('app_affaire_attribut_ouvrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/attribut_ouvrage/new.html.twig', [
            'attribut_ouvrage' => $attributOuvrage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_attribut_ouvrage_show', methods: ['GET'])]
    public function show(AttributOuvrage $attributOuvrage): Response
    {
        return $this->render('affaire/attribut_ouvrage/show.html.twig', [
            'attribut_ouvrage' => $attributOuvrage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_attribut_ouvrage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AttributOuvrage $attributOuvrage, AttributOuvrageRepository $attributOuvrageRepository): Response
    {
        $form = $this->createForm(AttributOuvrageType::class, $attributOuvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributOuvrageRepository->save($attributOuvrage, true);

            return $this->redirectToRoute('app_affaire_attribut_ouvrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/attribut_ouvrage/edit.html.twig', [
            'attribut_ouvrage' => $attributOuvrage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_attribut_ouvrage_delete', methods: ['POST'])]
    public function delete(Request $request, AttributOuvrage $attributOuvrage, AttributOuvrageRepository $attributOuvrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attributOuvrage->getId(), $request->request->get('_token'))) {
            $attributOuvrageRepository->remove($attributOuvrage, true);
        }

        return $this->redirectToRoute('app_affaire_attribut_ouvrage_index', [], Response::HTTP_SEE_OTHER);
    }
}
