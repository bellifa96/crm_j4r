<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\CategorieOuvrage;
use App\Form\Affaire\CategorieOuvrageType;
use App\Repository\Affaire\CategorieOuvrageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/categorieouvrage')]
class CategorieOuvrageController extends AbstractController
{
    #[Route('/', name: 'app_affaire_categorie_ouvrage_index', methods: ['GET'])]
    public function index(CategorieOuvrageRepository $categorieOuvrageRepository): Response
    {
        return $this->render('affaire/categorie_ouvrage/index.html.twig', [
            'categorie_ouvrages' => $categorieOuvrageRepository->findAll(),
            'title'=> "Les catégories des ouvrages",
            'nav'=> [['app_affaire_categorie_ouvrage_new',"Catégorie +"]]
        ]);
    }

    #[Route('/new', name: 'app_affaire_categorie_ouvrage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategorieOuvrageRepository $categorieOuvrageRepository): Response
    {
        $categorieOuvrage = new CategorieOuvrage();
        $form = $this->createForm(CategorieOuvrageType::class, $categorieOuvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieOuvrageRepository->save($categorieOuvrage, true);

            return $this->redirectToRoute('app_affaire_categorie_ouvrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/categorie_ouvrage/new.html.twig', [
            'categorie_ouvrage' => $categorieOuvrage,
            'form' => $form,
            'title'=> "Les catégories des ouvrages",
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_categorie_ouvrage_show', methods: ['GET'])]
    public function show(CategorieOuvrage $categorieOuvrage): Response
    {
        return $this->render('affaire/categorie_ouvrage/show.html.twig', [
            'categorie_ouvrage' => $categorieOuvrage,
            'title'=> "Les catégories des ouvrages",
            'nav'=> [['app_affaire_categorie_ouvrage_edit',"Catégorie +",$categorieOuvrage->getId()]]
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_categorie_ouvrage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieOuvrage $categorieOuvrage, CategorieOuvrageRepository $categorieOuvrageRepository): Response
    {
        $form = $this->createForm(CategorieOuvrageType::class, $categorieOuvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieOuvrageRepository->save($categorieOuvrage, true);

            return $this->redirectToRoute('app_affaire_categorie_ouvrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/categorie_ouvrage/edit.html.twig', [
            'categorie_ouvrage' => $categorieOuvrage,
            'form' => $form,
            'title'=> "Les catégories des ouvrages",
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_categorie_ouvrage_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieOuvrage $categorieOuvrage, CategorieOuvrageRepository $categorieOuvrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieOuvrage->getId(), $request->request->get('_token'))) {
            $categorieOuvrageRepository->remove($categorieOuvrage, true);
        }

        return $this->redirectToRoute('app_affaire_categorie_ouvrage_index', [], Response::HTTP_SEE_OTHER);
    }
}
