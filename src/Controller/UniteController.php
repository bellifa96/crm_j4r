<?php

namespace App\Controller;

use App\Entity\Unite;
use App\Form\UniteType;
use App\Repository\UniteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/unite')]
class UniteController extends AbstractController
{
    #[Route('/', name: 'app_unite_index', methods: ['GET'])]
    public function index(UniteRepository $uniteRepository): Response
    {
        return $this->render('unite/index.html.twig', [
            'unites' => $uniteRepository->findAll(),
            'title'=> "Liste des unités",
            'nav'=> [['app_unite_new','Ajouter une unité',[]]]
        ]);
    }

    #[Route('/new', name: 'app_unite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UniteRepository $uniteRepository): Response
    {
        $unite = new Unite();
        $form = $this->createForm(UniteType::class, $unite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uniteRepository->save($unite, true);

            return $this->redirectToRoute('app_unite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('unite/new.html.twig', [
            'unite' => $unite,
            'form' => $form,
            'title'=> "Créer une nouvelle unité",
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_unite_show', methods: ['GET'])]
    public function show(Unite $unite): Response
    {
        return $this->render('unite/show.html.twig', [
            'unite' => $unite,
            'title'=> "Unité : ".$unite->getLabel(),
            'nav'=> []
        ]);
    }

    #[Route('/{id}/edit', name: 'app_unite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Unite $unite, UniteRepository $uniteRepository): Response
    {
        $form = $this->createForm(UniteType::class, $unite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uniteRepository->save($unite, true);

            return $this->redirectToRoute('app_unite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('unite/edit.html.twig', [
            'unite' => $unite,
            'form' => $form,
            'title'=> "Modifier l'unité : ".$unite->getLabel(),
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_unite_delete', methods: ['POST'])]
    public function delete(Request $request, Unite $unite, UniteRepository $uniteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$unite->getId(), $request->request->get('_token'))) {
            $uniteRepository->remove($unite, true);
        }

        return $this->redirectToRoute('app_unite_index', [], Response::HTTP_SEE_OTHER);
    }
}
