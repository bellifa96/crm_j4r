<?php

namespace App\Controller\Society;

use App\Entity\Society\Agence;
use App\Form\Society\AgenceType;
use App\Repository\Society\AgenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/society/agence')]
class AgenceController extends AbstractController
{
    #[Route('/', name: 'app_society_agence_index', methods: ['GET'])]
    public function index(AgenceRepository $agenceRepository): Response
    {
        return $this->render('society/agence/index.html.twig', [
            'agences' => $agenceRepository->findAll(),
            'title'=>'Liste des agences',
            'nav'=>[],
        ]);
    }

    #[Route('/new', name: 'app_society_agence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AgenceRepository $agenceRepository): Response
    {
        $agence = new Agence();
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agenceRepository->save($agence, true);

            return $this->redirectToRoute('app_society_agence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('society/agence/new.html.twig', [
            'agence' => $agence,
            'form' => $form,
            'title'=>'Créer une agence',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_society_agence_show', methods: ['GET'])]
    public function show(Agence $agence): Response
    {
        return $this->render('society/agence/show.html.twig', [
            'agence' => $agence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_society_agence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agence $agence, AgenceRepository $agenceRepository): Response
    {
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agenceRepository->save($agence, true);

            return $this->redirectToRoute('app_society_agence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('society/agence/edit.html.twig', [
            'agence' => $agence,
            'form' => $form,
            'title'=>'Modifier l\'agence',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_society_agence_delete', methods: ['POST'])]
    public function delete(Request $request, Agence $agence, AgenceRepository $agenceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agence->getId(), $request->request->get('_token'))) {
            $agenceRepository->remove($agence, true);
        }

        return $this->redirectToRoute('app_society_agence_index', [], Response::HTTP_SEE_OTHER);
    }
}
