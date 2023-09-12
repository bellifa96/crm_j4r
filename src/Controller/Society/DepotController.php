<?php

namespace App\Controller\Society;

use App\Entity\Society\Depot;
use App\Form\Society\DepotType;
use App\Repository\Society\DepotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/society/depot')]
class DepotController extends AbstractController
{
    #[Route('/', name: 'app_society_depot_index', methods: ['GET'])]
    public function index(DepotRepository $depotRepository): Response
    {
        return $this->render('society/depot/index.html.twig', [
            'depots' => $depotRepository->findAll(),
            'title'=>'Liste des dépots',
            'nav'=>[],
        ]);
    }

    #[Route('/new', name: 'app_society_depot_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DepotRepository $depotRepository): Response
    {
        $depot = new Depot();
        $form = $this->createForm(DepotType::class, $depot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $depotRepository->save($depot, true);

            return $this->redirectToRoute('app_society_depot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('society/depot/new.html.twig', [
            'depot' => $depot,
            'form' => $form,
            'title'=>'Créer un dépot',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_society_depot_show', methods: ['GET'])]
    public function show(Depot $depot): Response
    {
        return $this->render('society/depot/show.html.twig', [
            'depot' => $depot,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_society_depot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Depot $depot, DepotRepository $depotRepository): Response
    {
        $form = $this->createForm(DepotType::class, $depot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $depotRepository->save($depot, true);

            return $this->redirectToRoute('app_society_depot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('society/depot/edit.html.twig', [
            'depot' => $depot,
            'form' => $form,
            'title'=>'Modifier le dépot',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_society_depot_delete', methods: ['POST'])]
    public function delete(Request $request, Depot $depot, DepotRepository $depotRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$depot->getId(), $request->request->get('_token'))) {
            $depotRepository->remove($depot, true);
        }

        return $this->redirectToRoute('app_society_depot_index', [], Response::HTTP_SEE_OTHER);
    }
}
