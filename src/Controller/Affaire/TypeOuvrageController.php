<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\TableDePrix;
use App\Entity\Affaire\TypeOuvrage;
use App\Form\Affaire\TypeOuvrageType;
use App\Repository\Affaire\AutreOuvrageRepository;
use App\Repository\Affaire\ComposantRepository;
use App\Repository\Affaire\OuvrageRepository;
use App\Repository\Affaire\TableDePrixRepository;
use App\Repository\Affaire\TypeComposantRepository;
use App\Repository\Affaire\TypeOuvrageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/type/ouvrage')]
class TypeOuvrageController extends AbstractController
{
    #[Route('/', name: 'app_affaire_type_ouvrage_index', methods: ['GET'])]
    public function index(TypeOuvrageRepository $typeOuvrageRepository, OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository, AutreOuvrageRepository $autreOuvrageRepository ): Response
    {
        $ouvrages = $ouvrageRepository->findByStatut(null);
        $composants = $composantRepository->findByStatut(null);

        foreach($composants as $composant){
            if(empty($composant->getDenomination())){
                $composant->setDenomination($composant->getTypeComposant()->getTitre());
                $composantRepository->add($composant);
            }
        }
        dd($typeOuvrageRepository->findAll()[0]->getAttributOuvrages());
        return $this->render('affaire/type_ouvrage/index.html.twig', [
            'ouvrages' => $ouvrages,
            'composants' => $composants,
            'typeOuvrages' => $typeOuvrageRepository->findAll(),
            'autreOuvrages' => $autreOuvrageRepository->findAll(),
            'title'=> "Type d'ouvrage",
            'nav'=> [['app_affaire_type_ouvrage_new',"Type d'ouvrage +"]]
        ]);
    }

    #[Route('/new', name: 'app_affaire_type_ouvrage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeOuvrageRepository $typeOuvrageRepository, TypeComposantRepository $typeComposantRepository, TableDePrixRepository $tableDePrixRepository): Response
    {
        $typeOuvrage = new TypeOuvrage();
        $form = $this->createForm(TypeOuvrageType::class, $typeOuvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeOuvrageRepository->save($typeOuvrage, true);

            //Ajoute des prix pour chaque nouveau type d'ouvrage créé
            foreach ($typeComposantRepository->findAll() as $typeComposant){
                $tableDePrix = new TableDePrix();
                $tableDePrix->setComposant($typeComposant->getId());
                $tableDePrix->setTypeOuvrage($typeOuvrage->getId());
                $tableDePrixRepository->add($tableDePrix);
            }

            return $this->redirectToRoute('app_affaire_type_ouvrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/type_ouvrage/new.html.twig', [
            'type_ouvrage' => $typeOuvrage,
            'form' => $form,
            'title'=> "Type d'ouvrage",
            'nav'=>[]
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_type_ouvrage_show', methods: ['GET'])]
    public function show(TypeOuvrage $typeOuvrage): Response
    {
        return $this->render('affaire/type_ouvrage/show.html.twig', [
            'type_ouvrage' => $typeOuvrage,
            'title'=> "Type d'ouvrage",
            'nav'=> [['app_affaire_type_ouvrage_edit',"Type d'ouvrage +",$typeOuvrage->getId()]]
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_type_ouvrage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeOuvrage $typeOuvrage, TypeOuvrageRepository $typeOuvrageRepository): Response
    {
        $form = $this->createForm(TypeOuvrageType::class, $typeOuvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeOuvrageRepository->save($typeOuvrage, true);

            return $this->redirectToRoute('app_affaire_type_ouvrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/type_ouvrage/edit.html.twig', [
            'type_ouvrage' => $typeOuvrage,
            'form' => $form,
            'title'=> "Type d'ouvrage",
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_type_ouvrage_delete', methods: ['POST'])]
    public function delete(Request $request, TypeOuvrage $typeOuvrage, TypeOuvrageRepository $typeOuvrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeOuvrage->getId(), $request->request->get('_token'))) {
            $typeOuvrageRepository->remove($typeOuvrage, true);
        }

        return $this->redirectToRoute('app_affaire_type_ouvrage_index', [], Response::HTTP_SEE_OTHER);
    }
}
