<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Statut;
use App\Form\Affaire\StatutType;
use App\Repository\Affaire\StatutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/statut')]
class StatutController extends AbstractController
{
    #[Route('/', name: 'app_affaire_statut_index', methods: ['GET'])]
    public function index(StatutRepository $statutRepository): Response
    {


        $statuts = $statutRepository->findAll();
        if(empty($statuts)){


            $data = [
                /*** statut demande commercial ***/
                ['titre'=>'A relancer','couleur'=>'white','couleurBG'=>'red','destination'=>['SCD']],
                ['titre'=>'A modifier','couleur'=>'white','couleurBG'=>'blue','destination'=>['SCD']],
                ['titre'=>'Négociation','couleur'=>'white','couleurBG'=>'grey','destination'=>['SCD']],
                ['titre'=>'En attente OS','couleur'=>'white','couleurBG'=>'orange','destination'=>['SCD']],
                ['titre'=>'Os validé','couleur'=>'white','couleurBG'=>'green','destination'=>['SCD']],
                ['titre'=>'Non réalisé','couleur'=>'white','couleurBG'=>'yellow','destination'=>['SCD']],

                /*** statut demande ***/

                ['titre'=>'En attente éléments client','couleur'=>'white','couleurBG'=>'black','destination'=>['SD']],
                ['titre'=>'A transmettre','couleur'=>'white','couleurBG'=>'black','destination'=>['SD']],
                ['titre'=>'A traiter','couleur'=>'white','couleurBG'=>'black','destination'=>['SD']],
                ['titre'=>'En cours de relevé','couleur'=>'white','couleurBG'=>'black','destination'=>['SD']],
                ['titre'=>'En cours de devis','couleur'=>'white','couleurBG'=>'black','destination'=>['SD']],
                ['titre'=>'En attente validation Direction','couleur'=>'white','couleurBG'=>'black','destination'=>['SD']],
                ['titre'=>'Devis validé direction','couleur'=>'white','couleurBG'=>'black','destination'=>['SD']],
                ['titre'=>'Devis en attente envoie','couleur'=>'white','couleurBG'=>'black','destination'=>['SD']],
                ['titre'=>'Devis envoyé','couleur'=>'white','couleurBG'=>'black','destination'=>['SD']],
                ['titre'=>'A modifier suite retour client','couleur'=>'white','couleurBG'=>'black','destination'=>['SD']],

            ];


            foreach ($data as $val){
                $statut = new Statut();
                $statut->setTitre($val['titre']);
                $statut->setCouleur($val['couleur']);
                $statut->setCouleurBG($val['couleurBG']);
                $statut->setDestination($val['destination']);
                $statutRepository->add($statut);
            }

        }
        return $this->render('affaire/statut/index.html.twig', [
            'statuts' => $statuts,
            'title'=> 'Statuts',
            'nav'=>[['app_affaire_statut_new','Statut +']]
        ]);
    }

    #[Route('/new', name: 'app_affaire_statut_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StatutRepository $statutRepository): Response
    {
        $statut = new Statut();
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statutRepository->add($statut, true);

            return $this->redirectToRoute('app_affaire_statut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/statut/new.html.twig', [
            'statut' => $statut,
            'form' => $form,
            'title'=> 'Créer un nouveau statut',
            'nav'=>[]
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_statut_show', methods: ['GET'])]
    public function show(Statut $statut): Response
    {
        return $this->render('affaire/statut/show.html.twig', [
            'statut' => $statut,
            'title'=> 'Le '.$statut->getTitre(),
            'nav'=>[]
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_statut_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Statut $statut, StatutRepository $statutRepository): Response
    {
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statutRepository->add($statut, true);

            return $this->redirectToRoute('app_affaire_statut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/statut/edit.html.twig', [
            'statut' => $statut,
            'form' => $form,
            'title'=> 'Modifier le statut '.$statut->getTitre(),
            'nav'=>[]
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_statut_delete', methods: ['POST'])]
    public function delete(Request $request, Statut $statut, StatutRepository $statutRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statut->getId(), $request->request->get('_token'))) {
            $statutRepository->remove($statut, true);
        }

        return $this->redirectToRoute('app_affaire_statut_index', [], Response::HTTP_SEE_OTHER);
    }
}
