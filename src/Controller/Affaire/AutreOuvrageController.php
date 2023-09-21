<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\AutreOuvrage;
use App\Form\Affaire\AutreOuvrageType;
use App\Repository\Affaire\AutreOuvrageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/autre/ouvrage')]
class AutreOuvrageController extends AbstractController
{
    #[Route('/', name: 'app_affaire_autre_ouvrage_index', methods: ['GET'])]
    public function index(AutreOuvrageRepository $autreOuvrageRepository): Response
    {
        return $this->render('affaire/autre_ouvrage/index.html.twig', [
            'autre_ouvrages' => $autreOuvrageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_affaire_autre_ouvrage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AutreOuvrageRepository $autreOuvrageRepository): Response
    {
        $autreOuvrage = new AutreOuvrage();
        $form = $this->createForm(AutreOuvrageType::class, $autreOuvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $autreOuvrageRepository->save($autreOuvrage, true);

            return $this->redirectToRoute('app_affaire_autre_ouvrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/autre_ouvrage/new.html.twig', [
            'autre_ouvrage' => $autreOuvrage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_autre_ouvrage_show', methods: ['GET'])]
    public function show(AutreOuvrage $autreOuvrage): Response
    {
        return $this->render('affaire/autre_ouvrage/show.html.twig', [
            'autre_ouvrage' => $autreOuvrage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_autre_ouvrage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AutreOuvrage $autreOuvrage, AutreOuvrageRepository $autreOuvrageRepository): Response
    {
        // Créer le formulaire en utilisant votre fonction buildForm
        $form = $this->createForm(AutreOuvrageType::class, $autreOuvrage);

        // Traitement du formulaire soumis
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les données dans la base de données
            $autreOuvrageRepository->save($autreOuvrage, true);

            // Calculer le prix unitaire de l'ouvrage
            $prixUnitaire = ($autreOuvrage->getMontage() +
                    $autreOuvrage->getDemontage() +
                    $autreOuvrage->getTransportAller() +
                    $autreOuvrage->getTransportRetour() +
                    $autreOuvrage->getManutentionAppro() +
                    $autreOuvrage->getManutentionRepli() +
                    $autreOuvrage->getVente() +
                $autreOuvrage->getLocation());

            // Mettre à jour le prix unitaire de l'ouvrage dans l'objet AutreOuvrage
            $autreOuvrage->setPrixUnitaire($prixUnitaire);

            // Sauvegarder à nouveau l'objet AutreOuvrage avec le prix unitaire mis à jour
            $autreOuvrageRepository->save($autreOuvrage, true);
            return $this->redirectToRoute('app_affaire_type_ouvrage_index', [], Response::HTTP_SEE_OTHER);
        }

        // Formater les valeurs numériques avant de les passer au formulaire
        // Utilisez number_format ici pour formater les valeurs avec le nombre de décimales souhaité
        $autreOuvrageData = [
            'designation' => $autreOuvrage->getDesignation(),
            'montage' => number_format($autreOuvrage->getMontage(), 2, ',', ''),
            'demontage' => number_format($autreOuvrage->getDemontage(), 2, ',', ''),
            'transportAller' => number_format($autreOuvrage->getTransportAller(), 2, ',', ''),
            'transportRetour' => number_format($autreOuvrage->getTransportRetour(), 2, ',', ''),
            'manutentionAppro' => number_format($autreOuvrage->getManutentionAppro(), 2, ',', ''),
            'manutentionRepli' => number_format($autreOuvrage->getManutentionRepli(), 2, ',', ''),
            'vente' => number_format($autreOuvrage->getVente(), 2, ',', ''),
            'location' => number_format($autreOuvrage->getLocation(), 2, ',', ''),
            'marge' => number_format($autreOuvrage->getMarge(), 3, ',', ''),
        ];

        return $this->renderForm('affaire/autre_ouvrage/edit.html.twig', [
            'autre_ouvrage' => $autreOuvrage,
            'form' => $form,
            'title' => $autreOuvrage->getDesignation(),
            'nav' => [],
            'autre_ouvrage_data' => $autreOuvrageData,
        ]);
    }


    #[Route('/{id}', name: 'app_affaire_autre_ouvrage_delete', methods: ['POST'])]
    public function delete(Request $request, AutreOuvrage $autreOuvrage, AutreOuvrageRepository $autreOuvrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$autreOuvrage->getId(), $request->request->get('_token'))) {
            $autreOuvrageRepository->remove($autreOuvrage, true);
        }

        return $this->redirectToRoute('app_affaire_autre_ouvrage_index', [], Response::HTTP_SEE_OTHER);
    }
}
