<?php

namespace App\Controller\Contact;

use App\Entity\Contact\ContactService;
use App\Entity\Interlocuteur\Activite;
use App\Entity\User\Service;
use App\Form\Contact\ContactServiceType;
use App\Repository\Contact\ContactServiceRepository;
use App\Repository\Interlocuteur\ActiviteRepository;
use App\Repository\User\ServiceRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[Route('/contact/service')]
class ContactServiceController extends AbstractController
{
    #[Route('/', name: 'app_contact_service_index', methods: ['GET'])]
    public function index(ContactServiceRepository $contactServiceRepository): Response
    {
        return $this->render('contact/contact_service/index.html.twig', [
            'contact_services' => $contactServiceRepository->findAll(),
            'title'=>'Liste des Service',
            'nav'=> [['app_contact_service_new','Ajouter un service']]
        ]);
    }


    #[Route('/new/modal', name: 'app_contact_service_new_modal', methods: ['GET', 'POST'])]
    public function getModal(Request $request, Environment $environment): Response
    {

        $response = new Response();
        try {
            $html = $environment->render("contact/contact/add_service.html.twig",);
        } catch (LoaderError $e) {
            dd($e);
        } catch (RuntimeError $e) {
            dd($e);
        } catch (SyntaxError $e) {
            dd($e);
        }
        $response->setContent(json_encode(['code' => 200, 'message' => $html]));
        return $response;
    }


    #[Route('/new/service', name: 'app_contact_service_new_service', methods: ['GET', 'POST'])]
    public function newService(Request $request, ContactServiceRepository $serviceRepository): Response
    {

        $data = $request->request->all()['service'];
        $response = new Response();

        if (!empty($data['titre']) and !empty($data['code'])) {
            $service = new ContactService();
            $service->setTitre(htmlspecialchars($data['titre'], ENT_QUOTES, 'UTF-8'));
            $service->setCode(htmlspecialchars($data['code'], ENT_QUOTES, 'UTF-8'));
            try {
                $serviceRepository->add($service);
                $response->setContent(json_encode(['code' => 200, 'message' => ['id' => $service->getId(), 'titre' => $service->getTitre()]]));
            } catch (UniqueConstraintViolationException $e) {
                $response->setContent(json_encode(['code' => 404, 'message' => "Une activité avec le même titre existe dans la base de données"]));
            }
        } else {
            $response->setContent(json_encode(['code' => 404, 'message' => 'Veuillez remplir tous les champs du formulaire']));
        }
        return $response;

    }

    #[Route('/new', name: 'app_contact_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactServiceRepository $contactServiceRepository): Response
    {
        $contactService = new ContactService();
        $form = $this->createForm(ContactServiceType::class, $contactService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactServiceRepository->add($contactService);
            return $this->redirectToRoute('app_contact_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/contact_service/new.html.twig', [
            'contact_service' => $contactService,
            'form' => $form,
            'title'=>'Liste des Service',
            'nav'=> [['app_contact_service_new','Ajouter un service']]
        ]);
    }

    #[Route('/{id}', name: 'app_contact_service_show', methods: ['GET'])]
    public function show(ContactService $contactService): Response
    {
        return $this->render('contact/contact_service/show.html.twig', [
            'contact_service' => $contactService,
            'title'=>'Liste des Service',
            'nav'=> [['app_contact_service_new','Ajouter un service']]
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContactService $contactService, ContactServiceRepository $contactServiceRepository): Response
    {
        $form = $this->createForm(ContactServiceType::class, $contactService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactServiceRepository->add($contactService);
            return $this->redirectToRoute('app_contact_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/contact_service/edit.html.twig', [
            'contact_service' => $contactService,
            'form' => $form,
            'title'=>'Liste des Service',
            'nav'=> [['app_contact_service_new','Ajouter un service']]
        ]);
    }

    #[Route('/{id}', name: 'app_contact_service_delete', methods: ['POST'])]
    public function delete(Request $request, ContactService $contactService, ContactServiceRepository $contactServiceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactService->getId(), $request->request->get('_token'))) {
            $contactServiceRepository->remove($contactService);
        }

        return $this->redirectToRoute('app_contact_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
