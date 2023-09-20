<?php

namespace App\Controller\Society;

use App\Entity\Society\Rib;
use App\Form\Society\RibType;
use App\Repository\Society\RibRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/society/rib')]
class RibController extends AbstractController
{
    #[Route('/', name: 'app_society_rib_index', methods: ['GET'])]
    public function index(RibRepository $ribRepository): Response
    {
        return $this->render('society/rib/index.html.twig', [
            'ribs' => $ribRepository->findAll(),
            'title'=>'Liste des rib',
            'nav'=>[],
        ]);
    }

    #[Route('/new', name: 'app_society_rib_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RibRepository $ribRepository): Response
    {
        $rib = new Rib();
        $form = $this->createForm(RibType::class, $rib);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ribRepository->add($rib, true);

            return $this->redirectToRoute('app_society_rib_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('society/rib/new.html.twig', [
            'rib' => $rib,
            'form' => $form,
            'title'=>'Créer un rib',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_society_rib_show', methods: ['GET'])]
    public function show(Rib $rib): Response
    {
        return $this->render('society/rib/show.html.twig', [
            'rib' => $rib,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_society_rib_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rib $rib, RibRepository $ribRepository): Response
    {
        $form = $this->createForm(RibType::class, $rib);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ribRepository->add($rib, true);

            return $this->redirectToRoute('app_society_rib_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('society/rib/edit.html.twig', [
            'rib' => $rib,
            'form' => $form,
            'title'=>'Modifier le rib',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_society_rib_delete', methods: ['POST'])]
    public function delete(Request $request, Rib $rib, RibRepository $ribRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rib->getId(), $request->request->get('_token'))) {
            $ribRepository->remove($rib, true);
        }

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }
}
