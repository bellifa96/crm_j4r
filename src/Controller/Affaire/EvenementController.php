<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Evenement;
use App\Entity\Demande;
use App\Form\Affaire\EvenementType;
use App\Repository\Affaire\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[Route('/affaire/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_affaire_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('affaire/evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'title' => 'Liste des tâches',
            'nav' => []
        ]);
    }

    #[Route('/new/modal', name: 'app_affaire_evenement_new_modal', methods: ['GET', 'POST'])]
    public function getModal(Request $request, Environment $environment): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $response = new Response();
        try {
            $html = $environment->render("affaire/evenement/modal_form.html.twig", [
                'form' => $form->createView()
            ]);
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

    #[Route('/new/evenement', name: 'app_affaire_evenement_new_evenement', methods: ['GET', 'POST'])]
    public function newEvenement(Request $request, EvenementRepository $evenementRepository): Response
    {

        $data = $request->request->all()['evenement'];
        $response = new Response();

        dd($request);

        if (!empty($data['evenement_titre']) and !empty($data['evenement_description']) and !empty($data['evenement_dateDeDebut'])
            and !empty($data['evenement_dateDeFin']) and !empty($data['evenement_priorite']) and !empty($data['evenement_typeDEvenement'])
            and !empty($data['evenement_attribueA'])) {
            $evenement = new Evenement();
            //$evenement->setDemande($this->get);
            $evenement->setCreateur($this->getUser());
            $evenement->setTitre(htmlspecialchars($data['evenement_titre'], ENT_QUOTES, 'UTF-8'));
            $evenement->setDescription(htmlspecialchars($data['evenement_description'], ENT_QUOTES, 'UTF-8'));
            $evenement->setDateDeDebut(htmlspecialchars($data['evenement_dateDeDebut'], ENT_QUOTES, 'UTF-8'));
            $evenement->setDateDeFin(htmlspecialchars($data['evenement_dateDeFin'], ENT_QUOTES, 'UTF-8'));
            $evenement->setPriorite(htmlspecialchars($data['evenement_priorite'], ENT_QUOTES, 'UTF-8'));
            $evenement->setTypeDEvenement(htmlspecialchars($data['evenement_typeDEvenement'], ENT_QUOTES, 'UTF-8'));
            $evenement->setAttribueA(htmlspecialchars($data['evenement_attribueA'], ENT_QUOTES, 'UTF-8'));

            //dd($evenement);
            try {
                $evenementRepository->add($evenement);
                $response->setContent(json_encode(['code' => 200, 'message' => ['id' => $evenement->getId(), 'titre' => $evenement->getTitre()]]));
            } catch (UniqueConstraintViolationException $e) {
                $response->setContent(json_encode(['code' => 404, 'message' => "Une activité avec le même titre existe dans la base de données"]));
            }
        } else {
            $response->setContent(json_encode(['code' => 404, 'message' => 'Veuillez remplir tous les champs du formulaire']));
        }
        return $response;

    }

    #[Route('/new/{id}', name: 'app_affaire_evenement_new', methods: ['GET', 'POST'])]
    public function new(Demande $demande, Request $request, EvenementRepository $evenementRepository): Response
    {
        $evenement = new Evenement();
        $evenement->setCreateur($this->getUser());
        $demande->addEvenement($evenement);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->add($evenement);
            return $this->redirectToRoute('app_affaire_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
            'title' => 'Liste des tâches',
            'nav' => []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('affaire/evenement/show.html.twig', [
            'evenement' => $evenement,
            'title' => 'Liste des tâches',
            'nav' => []
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->add($evenement);
            return $this->redirectToRoute('app_affaire_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
            'title' => 'Liste des tâches',
            'nav' => []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token'))) {
            $evenementRepository->remove($evenement);
        }

        return $this->redirectToRoute('app_affaire_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
