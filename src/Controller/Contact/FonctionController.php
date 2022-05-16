<?php

namespace App\Controller\Contact;

use App\Entity\Contact\Fonction;
use App\Form\Contact\FonctionType;
use App\Repository\Contact\FonctionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact/fonction')]
class FonctionController extends AbstractController
{
    #[Route('/', name: 'app_contact_fonction_index', methods: ['GET'])]
    public function index(FonctionRepository $fonctionRepository): Response
    {
        return $this->render('contact/fonction/index.html.twig', [
            'fonctions' => $fonctionRepository->findAll(),
            'nav'=>[],
            'title'=>'Contacts',
        ]);
    }

    #[Route('/new', name: 'app_contact_fonction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FonctionRepository $fonctionRepository): Response
    {
        $fonction = new Fonction();
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fonctionRepository->add($fonction);
            return $this->redirectToRoute('app_contact_fonction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/fonction/new.html.twig', [
            'fonction' => $fonction,
            'form' => $form,
            'nav'=>[],
            'title'=>'Contacts',
        ]);
    }

    #[Route('/{id}', name: 'app_contact_fonction_show', methods: ['GET'])]
    public function show(Fonction $fonction): Response
    {
        return $this->render('contact/fonction/show.html.twig', [
            'fonction' => $fonction,
            'nav'=>[],
            'title'=>'Contacts',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_fonction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fonction $fonction, FonctionRepository $fonctionRepository): Response
    {
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fonctionRepository->add($fonction);
            return $this->redirectToRoute('app_contact_fonction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/fonction/edit.html.twig', [
            'fonction' => $fonction,
            'form' => $form,
            'nav'=>[],
            'title'=>'Contacts',
        ]);
    }

    #[Route('/{id}', name: 'app_contact_fonction_delete', methods: ['POST'])]
    public function delete(Request $request, Fonction $fonction, FonctionRepository $fonctionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fonction->getId(), $request->request->get('_token'))) {
            $fonctionRepository->remove($fonction);
        }

        return $this->redirectToRoute('app_contact_fonction_index', [], Response::HTTP_SEE_OTHER);
    }
}
