<?php

namespace App\Controller\User;

use App\Entity\User\Service;
use App\Form\User\ServiceType;
use App\Repository\User\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/service')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'app_user_service_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('user/service/index.html.twig', [
            'services' => $serviceRepository->findAll(),
            'title'  => 'Liste des services',
            'nav' => [],

        ]);
    }

    #[Route('/new', name: 'app_user_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceRepository $serviceRepository): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceRepository->add($service);
            return $this->redirectToRoute('app_user_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/service/new.html.twig', [
            'service' => $service,
            'form' => $form,
            'title'  => 'Liste des services',
            'nav' => [],

        ]);
    }

    #[Route('/{id}', name: 'app_user_service_show', methods: ['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('user/service/show.html.twig', [
            'service' => $service,
            'title'  => 'Liste des services',
            'nav' => [],

        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceRepository->add($service);
            return $this->redirectToRoute('app_user_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
            'title'  => 'Liste des services',
            'nav' => [],

        ]);
    }

    #[Route('/{id}', name: 'app_user_service_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $serviceRepository->remove($service);
        }

        return $this->redirectToRoute('app_user_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
