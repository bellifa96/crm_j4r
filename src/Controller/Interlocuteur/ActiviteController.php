<?php

namespace App\Controller\Interlocuteur;

use App\Entity\Interlocuteur\Activite;
use App\Form\Interlocuteur\ActiviteType;
use App\Repository\Interlocuteur\ActiviteRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[Route('/interlocuteur/activite')]
class ActiviteController extends AbstractController
{
    #[Route('/', name: 'app_interlocuteur_activite_index', methods: ['GET'])]
    public function index(ActiviteRepository $activiteRepository): Response
    {
        return $this->render('interlocuteur/activite/index.html.twig', [
            'activites' => $activiteRepository->findAll(),
            'title' => 'a',
            'nav' => [],
        ]);
    }

    #[Route('/new', name: 'app_interlocuteur_activite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActiviteRepository $activiteRepository): Response
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activiteRepository->add($activite);
            return $this->redirectToRoute('app_interlocuteur_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interlocuteur/activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form,
            'title' => 'a',
            'nav' => [],
        ]);
    }


    #[Route('/new/modal', name: 'app_interlocuteur_activite_new_modal', methods: ['GET', 'POST'])]
    public function getModal(Request $request, Environment $environment): Response
    {

        $response = new Response();
        try {
            $html = $environment->render("interlocuteur/interlocuteur/activite_modal_form.html.twig",);
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


    #[Route('/new/app', name: 'app_interlocuteur_activite_new_app', methods: ['GET', 'POST'])]
    public function newApp(Request $request, ActiviteRepository $activiteRepository): Response
    {

        $data = $request->request->all()['activite'];
        $response = new Response();

        if (!empty($data['titre']) and !empty($data['code'])) {
            $activite = new Activite();
            $activite->setTitre(htmlspecialchars($data['titre'], ENT_QUOTES, 'UTF-8'));
            $activite->setCode(htmlspecialchars($data['code'], ENT_QUOTES, 'UTF-8'));
            try {
                $activiteRepository->add($activite);
                $response->setContent(json_encode(['code' => 200, 'message' => ['id' => $activite->getId(), 'titre' => $activite->getTitre()]]));
            } catch (UniqueConstraintViolationException $e) {
                $response->setContent(json_encode(['code' => 404, 'message' => "Une activité avec le même titre existe dans la base de données"]));
            }
        } else {
            $response->setContent(json_encode(['code' => 404, 'message' => 'Veuillez remplir tous les champs du formulaire']));
        }
        return $response;

    }


    #[Route('/{id}', name: 'app_interlocuteur_activite_show', methods: ['GET'])]
    public function show(Activite $activite): Response
    {
        return $this->render('interlocuteur/activite/show.html.twig', [
            'activite' => $activite,
            'title' => 'a',
            'nav' => [],
        ]);
    }

    #[Route('/{id}/edit', name: 'app_interlocuteur_activite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activite $activite, ActiviteRepository $activiteRepository): Response
    {
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activiteRepository->add($activite);
            return $this->redirectToRoute('app_interlocuteur_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interlocuteur/activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form,
            'title' => 'a',
            'nav' => [],
        ]);
    }

    #[Route('/{id}', name: 'app_interlocuteur_activite_delete', methods: ['POST'])]
    public function delete(Request $request, Activite $activite, ActiviteRepository $activiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $activite->getId(), $request->request->get('_token'))) {
            $activiteRepository->remove($activite);
        }

        return $this->redirectToRoute('app_interlocuteur_activite_index', [], Response::HTTP_SEE_OTHER);
    }
}
