<?php

namespace App\Controller\Contact;

use App\Entity\Contact\Contact;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Form\Contact\ContactType;
use App\Repository\Contact\ContactRepository;
use App\Repository\DemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact/contact')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
            'nav' => [['app_contact_service_index', 'Listes des Services'], ['app_contact_service_new', 'Service +']],
            'title' => 'Contacts',
        ]);
    }

    #[Route('/new/{id}', name: 'app_contact_contact_new', methods: ['GET', 'POST'])]
    public function new(Interlocuteur $interlocuteur, Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $contact->setSociete($interlocuteur);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $photo = $form->get('photo')->getData();


            if ($photo) {
                $newFilename = $contact->getId() . '.' . $photo->guessExtension();
                try {
                    $photo->move(
                        __DIR__ . '/../../../public/uploads/photo/contact/',
                        $newFilename
                    );
                } catch (FileException $e) {

                    $this->addFlash('danger', $e->getMessage());
                }

                $contact->setPhoto($newFilename);
            }

            $contactRepository->add($contact);

            return $this->redirectToRoute('app_contact_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'nav' => [],
            'title' => 'Contacts',
        ]);
    }

    #[Route('/{id}', name: 'app_contact_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/contact/show.html.twig', [
            'contact' => $contact,
            'nav' => [['app_contact_contact_edit', 'Modifier', $contact->getId()]],
            'title' => $contact->getNom() . " " . $contact->getPrenom(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $newFilename = $contact->getId() . '.' . $photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        __DIR__ . '/../../../public/uploads/photo/contact/',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $contact->setPhoto($newFilename);
            }

            $contactRepository->add($contact);
            return $this->redirectToRoute('app_contact_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'nav' => [],
            'title' => $contact->getNom() . " " . $contact->getPrenom(),
        ]);
    }

    #[Route('/{id}', name: 'app_contact_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $contactRepository->remove($contact);
        }

        return $this->redirectToRoute('app_contact_contact_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/interlocteur/contact/get', name: 'app_contact_interlocuteur_get_contact', methods: ['POST'])]
    public function getInterlocuteurContact(Request $request, ContactRepository $contactRepository, DemandeRepository $demandeRepository): Response
    {
        $dataRequest = $request->request->all();

        key_exists('demande', $dataRequest) ? $demande = $dataRequest['demande'] : $demande = null;
        key_exists('id', $dataRequest) ? $id = $dataRequest['id'] : $id = null;
        key_exists('idClient', $dataRequest) ? $idClient = $dataRequest['idClient'] : $idClient = null;
        key_exists('idMaitreOuvrage', $dataRequest) ? $idMaitreOuvrage = $dataRequest['idMaitreOuvrage'] : $idMaitreOuvrage = null;
        key_exists('idIntermediaire', $dataRequest) ? $idItermediaire = $dataRequest['idIntermediaire'] : $idItermediaire = null;
        key_exists('role', $dataRequest) ? $role = $dataRequest['role'] : $role = null;

        if (!empty($id)) {
            $contacts = $contactRepository->findBySociete($id);
        } else {
            $contacts = $contactRepository->findAllBySocieteId($idClient, $idMaitreOuvrage, $idItermediaire);
        }
        $data = [];

        if (!empty($demande)) {
            $demande = $demandeRepository->find($demande);
        }

        foreach ($contacts as $val) {

            $selected = false;
            if (!empty($demande)) {
                if ($role == "client") {
                    if ($val == $demande->getContactPrincipalClient()) {
                        $selected = true;
                    }
                } elseif ($role == "intermediaire") {
                    if ($val == $demande->getContactPrincipalIntermediaire()) {
                        $selected = true;
                    }
                } elseif ($role == "maitreDOuvrage") {
                    if ($val == $demande->getContactPrincipalMaitreDOuvrage()) {
                        $selected = true;
                    }
                } else {
                    if ($demande->getContactsSecondaires()->contains($val)) {
                        $selected = true;
                    }

                }
            }


            $data[] = [
                'id' => $val->getId(),
                'text' => $val->getNom() . " " . $val->getPrenom(),
                'selected' => $selected,
            ];
        }
        //dd($contacts);
        //dd($data);
        $response = new Response();
        $response->setContent(json_encode($data));
        return $response;
    }
}
