<?php

namespace App\Controller\Contact;

use App\Entity\Contact\ContactService;
use App\Form\Contact\ContactServiceType;
use App\Repository\Contact\ContactServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact/contact/service')]
class ContactServiceController extends AbstractController
{
    #[Route('/', name: 'app_contact_contact_service_index', methods: ['GET'])]
    public function index(ContactServiceRepository $contactServiceRepository): Response
    {
        return $this->render('contact/contact_service/index.html.twig', [
            'contact_services' => $contactServiceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contact_contact_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactServiceRepository $contactServiceRepository): Response
    {
        $contactService = new ContactService();
        $form = $this->createForm(ContactServiceType::class, $contactService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactServiceRepository->add($contactService);
            return $this->redirectToRoute('app_contact_contact_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/contact_service/new.html.twig', [
            'contact_service' => $contactService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_contact_service_show', methods: ['GET'])]
    public function show(ContactService $contactService): Response
    {
        return $this->render('contact/contact_service/show.html.twig', [
            'contact_service' => $contactService,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_contact_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContactService $contactService, ContactServiceRepository $contactServiceRepository): Response
    {
        $form = $this->createForm(ContactServiceType::class, $contactService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactServiceRepository->add($contactService);
            return $this->redirectToRoute('app_contact_contact_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/contact_service/edit.html.twig', [
            'contact_service' => $contactService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_contact_service_delete', methods: ['POST'])]
    public function delete(Request $request, ContactService $contactService, ContactServiceRepository $contactServiceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactService->getId(), $request->request->get('_token'))) {
            $contactServiceRepository->remove($contactService);
        }

        return $this->redirectToRoute('app_contact_contact_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
