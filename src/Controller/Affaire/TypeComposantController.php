<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\TableDePrix;
use App\Entity\Affaire\TypeComposant;
use App\Form\Affaire\TypeComposantType;
use App\Repository\Affaire\TableDePrixRepository;
use App\Repository\Affaire\TypeComposantRepository;
use App\Repository\Affaire\TypeOuvrageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/type/composant')]
class TypeComposantController extends AbstractController
{
    #[Route('/', name: 'app_affaire_type_composant_index', methods: ['GET'])]
    public function index(TypeComposantRepository $typeComposantRepository): Response
    {
        return $this->render('affaire/type_composant/index.html.twig', [
            'type_composants' => $typeComposantRepository->findAll(),
            'title'=> 'Liste des composants',
            'nav'=> [['app_affaire_type_composant_new','Type +']]
        ]);
    }

    #[Route('/new', name: 'app_affaire_type_composant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeComposantRepository $typeComposantRepository, TypeOuvrageRepository $typeOuvrageRepository, TableDePrixRepository $tableDePrixRepository): Response
    {
        $typeComposant = new TypeComposant();
        $form = $this->createForm(TypeComposantType::class, $typeComposant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeComposantRepository->add($typeComposant, true);

            //Ajoute des prix pour chaque nouveau type de composant créé
            foreach ($typeOuvrageRepository->findAll() as $typeOuvrage){
                $tableDePrix = new TableDePrix();
                $tableDePrix->setComposant($typeComposant);
                $tableDePrix->setTypeOuvrage($typeOuvrage);
                $tableDePrixRepository->save($tableDePrix);
            }

            return $this->redirectToRoute('app_affaire_type_composant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/type_composant/new.html.twig', [
            'type_composant' => $typeComposant,
            'form' => $form,
            'title'=> 'Liste des composants',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_type_composant_show', methods: ['GET'])]
    public function show(TypeComposant $typeComposant): Response
    {
        return $this->render('affaire/type_composant/show.html.twig', [
            'type_composant' => $typeComposant,
            'title'=> 'Liste des composants',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_type_composant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeComposant $typeComposant, TypeComposantRepository $typeComposantRepository): Response
    {
        $form = $this->createForm(TypeComposantType::class, $typeComposant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeComposantRepository->add($typeComposant, true);

            return $this->redirectToRoute('app_affaire_type_composant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/type_composant/edit.html.twig', [
            'type_composant' => $typeComposant,
            'form' => $form,
            'title'=> 'Liste des composants',
            'nav'=>[],
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_type_composant_delete', methods: ['POST'])]
    public function delete(Request $request, TypeComposant $typeComposant, TypeComposantRepository $typeComposantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeComposant->getId(), $request->request->get('_token'))) {
            $typeComposantRepository->remove($typeComposant, true);
        }

        return $this->redirectToRoute('app_affaire_type_composant_index', [], Response::HTTP_SEE_OTHER);
    }
}
