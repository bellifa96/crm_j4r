<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Transport;
use App\Form\Affaire\TransportType;
use App\Repository\Affaire\TransportRepository;
use App\Repository\DemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/transport')]
class TransportController extends AbstractController
{
    #[Route('/', name: 'app_affaire_transport_index', methods: ['GET'])]
    public function index(TransportRepository $transportRepository): Response
    {
        return $this->render('affaire/transport/index.html.twig', [
            'transports' => $transportRepository->findAll(),
            'title' => '',
            'nav'=>[],
        ]);
    }

    #[Route('/chantier/code/', name: 'app_affaire_transport_chantier_code', methods: ['GET','POST'])]
    public function chantierCode(DemandeRepository $demandeRepository,Request $request): Response
    {
        $q = $request->query->get('term') || null;
        $data =  $demandeRepository->findAllByQ($q);

        $res = [];
        foreach ($data as $value){
            foreach ($value as $val){
                $res[]= $val;
            }
        }
        return new Response(json_encode($res));
    }


    #[Route('/new', name: 'app_affaire_transport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TransportRepository $transportRepository): Response
    {
        $transport = new Transport();
        $transport->setDonneurDOrdre($this->getUser());
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transportRepository->add($transport, true);

            return $this->redirectToRoute('app_affaire_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/transport/new.html.twig', [
            'transport' => $transport,
            'form' => $form,
            'title' => '',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_transport_show', methods: ['GET'])]
    public function show(Transport $transport): Response
    {
        return $this->render('affaire/transport/show.html.twig', [
            'transport' => $transport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_transport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transport $transport, TransportRepository $transportRepository): Response
    {
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transportRepository->add($transport, true);

            return $this->redirectToRoute('app_affaire_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/transport/edit.html.twig', [
            'transport' => $transport,
            'form' => $form,
            'title' => '',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_transport_delete', methods: ['POST'])]
    public function delete(Request $request, Transport $transport, TransportRepository $transportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transport->getId(), $request->request->get('_token'))) {
            $transportRepository->remove($transport, true);
        }

        return $this->redirectToRoute('app_affaire_transport_index', [], Response::HTTP_SEE_OTHER);
    }
}
