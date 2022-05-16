<?php

namespace App\Controller\Contact;

use App\Entity\Contact\Contact;
use App\Form\Contact\ContactType;
use App\Repository\Contact\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            'nav'=>[['app_contact_fonction_index','Listes des Fonctions'],['app_contact_fonction_new','Fonction +']],
            'title'=>'Contacts',
        ]);
    }

    #[Route('/new', name: 'app_contact_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact);
            return $this->redirectToRoute('app_contact_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'nav'=>[],
            'title'=>'Contacts',
        ]);
    }

    #[Route('/{id}', name: 'app_contact_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/contact/show.html.twig', [
            'contact' => $contact,
            'nav'=>[['Listes des Fonctions','app_contact_fonction_index'],['Fonction +','app_contact_fonction_new']],
            'title'=>'Contacts',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact);
            return $this->redirectToRoute('app_contact_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'nav'=>[],
            'title'=>'Contacts',
        ]);
    }

    #[Route('/{id}', name: 'app_contact_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $contactRepository->remove($contact);
        }

        return $this->redirectToRoute('app_contact_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
