<?php

namespace App\Controller\User;

use App\Entity\User\Poste;
use App\Form\User\PosteType;
use App\Repository\User\PosteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/poste')]
class PosteController extends AbstractController
{
    #[Route('/', name: 'app_user_poste_index', methods: ['GET'])]
    public function index(PosteRepository $posteRepository): Response
    {
        return $this->render('user/poste/index.html.twig', [
            'postes' => $posteRepository->findAll(),
            'title'  => 'Liste des postes',
            'nav' => [],
        ]);
    }

    #[Route('/new', name: 'app_user_poste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PosteRepository $posteRepository): Response
    {
        $poste = new Poste();
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteRepository->add($poste);
            return $this->redirectToRoute('app_user_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/poste/new.html.twig', [
            'poste' => $poste,
            'form' => $form,
            'title'  => 'Liste des postes',
            'nav' => [],

        ]);
    }

    #[Route('/{id}', name: 'app_user_poste_show', methods: ['GET'])]
    public function show(Poste $poste): Response
    {
        return $this->render('user/poste/show.html.twig', [
            'poste' => $poste,
            'title'  => 'Liste des postes',
            'nav' => [],

        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_poste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Poste $poste, PosteRepository $posteRepository): Response
    {
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteRepository->add($poste);
            return $this->redirectToRoute('app_user_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/poste/edit.html.twig', [
            'poste' => $poste,
            'form' => $form,
            'title'  => 'Liste des postes',
            'nav' => [],

        ]);
    }

    #[Route('/{id}', name: 'app_user_poste_delete', methods: ['POST'])]
    public function delete(Request $request, Poste $poste, PosteRepository $posteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poste->getId(), $request->request->get('_token'))) {
            $posteRepository->remove($poste);
        }

        return $this->redirectToRoute('app_user_poste_index', [], Response::HTTP_SEE_OTHER);
    }
}
