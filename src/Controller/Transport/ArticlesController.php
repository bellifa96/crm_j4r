<?php

namespace App\Controller\Transport;

use App\Entity\Transport\Articles;
use App\Form\Transport\ArticlesType;
use App\Repository\Transport\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transport/articles')]
class ArticlesController extends AbstractController
{
    #[Route('/', name: 'app_transport_articles_index', methods: ['GET'])]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('transport/articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
            'title'=>'Liste des articles',
            'nav'=>[],
        ]);
    }

    #[Route('/new', name: 'app_transport_articles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticlesRepository $articlesRepository): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->save($article, true);

            return $this->redirectToRoute('app_transport_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transport/articles/new.html.twig', [
            'article' => $article,
            'form' => $form,
            'title'=>'Créer un article',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_transport_articles_show', methods: ['GET'])]
    public function show(Articles $article): Response
    {
        return $this->render('transport/articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transport_articles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->save($article, true);

            return $this->redirectToRoute('app_transport_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transport/articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
            'title'=>'Modifier l\'article',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_transport_articles_delete', methods: ['POST'])]
    public function delete(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articlesRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_transport_articles_index', [], Response::HTTP_SEE_OTHER);
    }
}
