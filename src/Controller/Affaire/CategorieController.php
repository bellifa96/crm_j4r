<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Categorie;
use App\Form\Affaire\CategorieType;
use App\Repository\Affaire\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/categorie')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'app_affaire_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('affaire/categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'title'=> "Les catégories des composants",
            'nav'=> [['app_affaire_categorie_new',"Catégorie +"]]
        ]);
    }

    #[Route('/new', name: 'app_affaire_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategorieRepository $categorieRepository): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRepository->save($categorie, true);

            return $this->redirectToRoute('app_affaire_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            'title'=> "Les catégories des composants",
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('affaire/categorie/show.html.twig', [
            'categorie' => $categorie,
            'title'=> "Les catégories des composants",
            'nav'=> [['app_affaire_categorie_edit',"Catégorie +",$categorie->getId()]]
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, CategorieRepository $categorieRepository): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRepository->save($categorie, true);

            return $this->redirectToRoute('app_affaire_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            'title'=> "Les catégories des composants",
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, CategorieRepository $categorieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            $categorieRepository->remove($categorie, true);
        }

        return $this->redirectToRoute('app_affaire_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
