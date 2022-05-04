<?php

namespace App\Controller\Ged;

use App\Entity\Ged\Fichier;
use App\Form\Ged\FichierType;
use App\Repository\Ged\FichierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/ged/fichier')]
class FichierController extends AbstractController
{
    #[Route('/', name: 'app_ged_fichier_index', methods: ['GET'])]
    public function index(FichierRepository $fichierRepository): Response
    {
        return $this->render('ged/fichier/index.html.twig', [
            'fichiers' => $fichierRepository->findAll(),
            'title'=> 'Document',
            'nav'=>[],
        ]);
    }

    #[Route('/new', name: 'app_ged_fichier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FichierRepository $fichierRepository,SluggerInterface $slugger): Response
    {
        $fichier = new Fichier();
        $fichier->setCreateur($this->getUser());
        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('fichier')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    $brochureFile->move(
                        __DIR__."/../../../uploads/".$fichier->getTypeFichier()->getTitre()."/",
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $fichier->setFichier($newFilename);
            }

            $fichierRepository->add($fichier);
            return $this->redirectToRoute('app_ged_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ged/fichier/new.html.twig', [
            'fichier' => $fichier,
            'form' => $form,
            'title'=> 'Document',
            'nav'=>[],

        ]);
    }

    #[Route('/{id}', name: 'app_ged_fichier_show', methods: ['GET'])]
    public function show(Fichier $fichier): Response
    {
        return $this->render('ged/fichier/show.html.twig', [
            'fichier' => $fichier,
            'title'=> 'Document',
            'nav'=>[],

        ]);
    }

    #[Route('/{id}/edit', name: 'app_ged_fichier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fichier $fichier, FichierRepository $fichierRepository): Response
    {
        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichierRepository->add($fichier);
            return $this->redirectToRoute('app_ged_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ged/fichier/edit.html.twig', [
            'fichier' => $fichier,
            'form' => $form,
            'title'=> 'Document',
            'nav'=>[],

        ]);
    }

    #[Route('/{id}', name: 'app_ged_fichier_delete', methods: ['POST'])]
    public function delete(Request $request, Fichier $fichier, FichierRepository $fichierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fichier->getId(), $request->request->get('_token'))) {
            $fichierRepository->remove($fichier);
        }

        return $this->redirectToRoute('app_ged_fichier_index', [], Response::HTTP_SEE_OTHER);
    }
}
