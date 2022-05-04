<?php

namespace App\Controller\Ged;

use App\Entity\Ged\TypeFichier;
use App\Form\Ged\TypeFichierType;
use App\Repository\Ged\TypeFichierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ged/type/fichier')]
class TypeFichierController extends AbstractController
{
    #[Route('/', name: 'app_ged_type_fichier_index', methods: ['GET'])]
    public function index(TypeFichierRepository $typeFichierRepository): Response
    {
        return $this->render('ged/type_fichier/index.html.twig', [
            'type_fichiers' => $typeFichierRepository->findAll(),
            'title'=> 'Type de document',
            'nav'=>[],

        ]);
    }

    #[Route('/new', name: 'app_ged_type_fichier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeFichierRepository $typeFichierRepository,Filesystem $filesystem): Response
    {
        $typeFichier = new TypeFichier();
        $form = $this->createForm(TypeFichierType::class, $typeFichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(!$filesystem->exists(__DIR__.'/../../../uploads/')){
                $filesystem->mkdir(__DIR__.'/../../../uploads/', 0700);
            }
            if($filesystem->exists(__DIR__.'/../../../uploads/') and !$filesystem->exists(__DIR__.'/../../../uploads/'.$typeFichier->getTitre())){
                $filesystem->mkdir(__DIR__.'/../../../uploads/'.$typeFichier->getTitre(), 0700);
            }

            $typeFichierRepository->add($typeFichier);
            return $this->redirectToRoute('app_ged_type_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ged/type_fichier/new.html.twig', [
            'type_fichier' => $typeFichier,
            'form' => $form,
            'title'=> 'Type de document',
            'nav'=>[],

        ]);
    }

    #[Route('/{id}', name: 'app_ged_type_fichier_show', methods: ['GET'])]
    public function show(TypeFichier $typeFichier): Response
    {
        return $this->render('ged/type_fichier/show.html.twig', [
            'type_fichier' => $typeFichier,
            'title'=> 'Type de document',
            'nav'=>[],

        ]);

    }

    #[Route('/{id}/edit', name: 'app_ged_type_fichier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeFichier $typeFichier, TypeFichierRepository $typeFichierRepository,Filesystem $filesystem): Response
    {
        $form = $this->createForm(TypeFichierType::class, $typeFichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(!$filesystem->exists(__DIR__.'/../../../uploads/')){
                $filesystem->mkdir(__DIR__.'/../../../uploads/', 0700);
            }
            if($filesystem->exists(__DIR__.'/../../../uploads/') and !$filesystem->exists(__DIR__.'/../../../uploads/'.$typeFichier->getTitre())){
                $filesystem->mkdir(__DIR__.'/../../../uploads/'.$typeFichier->getTitre(), 0700);
            }

            $typeFichierRepository->add($typeFichier);
            return $this->redirectToRoute('app_ged_type_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ged/type_fichier/edit.html.twig', [
            'type_fichier' => $typeFichier,
            'form' => $form,
            'title'=> 'Type de document',
            'nav'=>[],

        ]);
    }

    #[Route('/{id}', name: 'app_ged_type_fichier_delete', methods: ['POST'])]
    public function delete(Request $request, TypeFichier $typeFichier, TypeFichierRepository $typeFichierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeFichier->getId(), $request->request->get('_token'))) {
            $typeFichierRepository->remove($typeFichier);
        }

        return $this->redirectToRoute('app_ged_type_fichier_index', [], Response::HTTP_SEE_OTHER);
    }
}
