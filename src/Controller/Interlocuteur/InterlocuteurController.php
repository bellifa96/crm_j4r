<?php

namespace App\Controller\Interlocuteur;

use App\Entity\Interlocuteur\Interlocuteur;
use App\Form\Interlocuteur\InterlocuteurType;
use App\Repository\Interlocuteur\InterlocuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/interlocuteur/interlocuteur')]
class InterlocuteurController extends AbstractController
{
    #[Route('/', name: 'app_interlocuteur_interlocuteur_index', methods: ['GET'])]
    public function index(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAll(),
            'title' => 'Liste des interlocuteurs'
        ]);
    }

    #[Route('/new', name: 'app_interlocuteur_interlocuteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InterlocuteurRepository $interlocuteurRepository): Response
    {
        $interlocuteur = new Interlocuteur();
        $form = $this->createForm(InterlocuteurType::class, $interlocuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($interlocuteur->getType() == "personne"){
                $interlocuteur->setSociete(NULL);
            }elseif($interlocuteur->getType() == "societe"){
                $interlocuteur->setPersonne(NULL);
            }

            $interlocuteurRepository->add($interlocuteur);
            return $this->redirectToRoute('app_interlocuteur_interlocuteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interlocuteur/interlocuteur/new.html.twig', [
            'interlocuteur' => $interlocuteur,
            'form' => $form,
            'title' => 'Liste des interlocuteurs'

        ]);
    }

    #[Route('/{id}', name: 'app_interlocuteur_interlocuteur_show', methods: ['GET'])]
    public function show(Interlocuteur $interlocuteur): Response
    {
        return $this->render('interlocuteur/interlocuteur/show.html.twig', [
            'interlocuteur' => $interlocuteur,
            'title' => 'Liste des interlocuteurs'

        ]);
    }

    #[Route('/{id}/edit', name: 'app_interlocuteur_interlocuteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Interlocuteur $interlocuteur, InterlocuteurRepository $interlocuteurRepository): Response
    {
        $form = $this->createForm(InterlocuteurType::class, $interlocuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interlocuteurRepository->add($interlocuteur);
            return $this->redirectToRoute('app_interlocuteur_interlocuteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interlocuteur/interlocuteur/edit.html.twig', [
            'interlocuteur' => $interlocuteur,
            'form' => $form,
            'title' => 'Liste des interlocuteurs'

        ]);
    }

    #[Route('/{id}', name: 'app_interlocuteur_interlocuteur_delete', methods: ['POST'])]
    public function delete(Request $request, Interlocuteur $interlocuteur, InterlocuteurRepository $interlocuteurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$interlocuteur->getId(), $request->request->get('_token'))) {
            $interlocuteurRepository->remove($interlocuteur);
        }

        return $this->redirectToRoute('app_interlocuteur_interlocuteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
