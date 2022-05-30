<?php

namespace App\Controller\Interlocuteur;

use App\Entity\Ged\Fichier;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Form\Ged\FichierType;
use App\Form\Interlocuteur\InterlocuteurType;
use App\Repository\Ged\FichierRepository;
use App\Repository\Interlocuteur\InterlocuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/interlocuteur/interlocuteur')]
class InterlocuteurController extends AbstractController
{
    #[Route('/', name: 'app_interlocuteur_interlocuteur_index', methods: ['GET'])]
    public function index(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAll(),
            'title' => 'Liste des interlocuteurs',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/new', name: 'app_interlocuteur_interlocuteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InterlocuteurRepository $interlocuteurRepository): Response
    {
        $interlocuteur = new Interlocuteur();
        $form = $this->createForm(InterlocuteurType::class, $interlocuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($interlocuteur->getType() == "personne") {
                $interlocuteur->setSociete(NULL);
            } elseif ($interlocuteur->getType() == "societe") {
                $interlocuteur->setPersonne(NULL);
            }

            $interlocuteurRepository->add($interlocuteur);
            return $this->redirectToRoute('app_interlocuteur_interlocuteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interlocuteur/interlocuteur/new.html.twig', [
            'interlocuteur' => $interlocuteur,
            'form' => $form,
            'title' => 'Liste des interlocuteurs',
            'nav' => [],

        ]);
    }

    #[Route('/{id}', name: 'app_interlocuteur_interlocuteur_show', methods: ['GET','POST'])]
    public function show(Request $request,Interlocuteur $interlocuteur,FichierRepository $fichierRepository, SluggerInterface $slugger): Response
    {
        $fichier = new Fichier();


        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('fichier')->getData();

            if ($brochureFile) {
                $fichier->setCreateur($this->getUser());
                $fichier->setInterlocuteur($interlocuteur);

                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                try {

                    $brochureFile->move(
                        __DIR__ . "/../../../uploads/" . $fichier->getTypeFichier()->getTitre() . "/",
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $fichier->setFichier($newFilename);
            }

            $fichierRepository->add($fichier);
        }

        return $this->render('interlocuteur/interlocuteur/show.html.twig', [
            'form'=>$form->createView(),
            'interlocuteur' => $interlocuteur,
            'title' => !empty($interlocuteur->getSociete()) ? $interlocuteur->getSociete()->getRaisonSociale() : $interlocuteur->getPersonne()->getNom(),
            'nav' => [['app_interlocuteur_interlocuteur_edit', 'Modifier', $interlocuteur->getId()]],

        ]);
    }

    #[Route('/{id}/edit', name: 'app_interlocuteur_interlocuteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Interlocuteur $interlocuteur, InterlocuteurRepository $interlocuteurRepository): Response
    {
        $form = $this->createForm(InterlocuteurType::class, $interlocuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($interlocuteur->getType() == "personne") {
                $interlocuteur->setSociete(NULL);
            } elseif ($interlocuteur->getType() == "societe") {
                $interlocuteur->setPersonne(NULL);
            }

            $interlocuteurRepository->add($interlocuteur);
            return $this->redirectToRoute('app_interlocuteur_interlocuteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interlocuteur/interlocuteur/edit.html.twig', [
            'interlocuteur' => $interlocuteur,
            'form' => $form,
            'title' => 'Liste des interlocuteurs',
            'nav' => [],
        ]);
    }

    #[Route('/{id}', name: 'app_interlocuteur_interlocuteur_delete', methods: ['POST'])]
    public function delete(Request $request, Interlocuteur $interlocuteur, InterlocuteurRepository $interlocuteurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $interlocuteur->getId(), $request->request->get('_token'))) {
            $interlocuteurRepository->remove($interlocuteur);
        }

        return $this->redirectToRoute('app_interlocuteur_interlocuteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
