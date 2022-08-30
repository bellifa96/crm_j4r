<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Devis;
use App\Entity\Affaire\Lot;
use App\Entity\Affaire\Ouvrage;
use App\Entity\Affaire\SousLot;
use App\Entity\Demande;
use App\Form\Affaire\DevisType;
use App\Repository\Affaire\DevisRepository;
use App\Repository\Affaire\OuvrageRepository;
use Doctrine\ORM\EntityManagerInterface;
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

#[Route('/affaire/devis')]
class DevisController extends AbstractController
{
    #[Route('/', name: 'app_affaire_devis_index', methods: ['GET'])]
    public function index(DevisRepository $devisRepository): Response
    {
        return $this->render('affaire/devis/index.html.twig', [
            'devis' => $devisRepository->findAll(),
            'title' => 'Liste des devis',
            'nav' => []
        ]);
    }

    #[Route('/new/{id}', name: 'app_affaire_devis_new', methods: ['GET', 'POST'])]
    public function new(Demande $demande, Request $request, DevisRepository $devisRepository): Response
    {


        $nom = $request->request->all()['devis']['nom'];

        $devis = new Devis();
        $devis->setTitre($nom);
        $devis->setDemande($demande);
        $devisRepository->add($devis);
        return $this->redirectToRoute('app_affaire_devis_edit', ['id' => $devis->getId()], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{id}', name: 'app_affaire_devis_show', methods: ['GET'])]
    public function show(Devis $devis): Response
    {
        return $this->render('affaire/devis/show.html.twig', [
            'devi' => $devis,
            'title' => 'Devis N° ' . $devis->getId(),
            'nav' => []
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_devis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devis $devis, DevisRepository $devisRepository): Response
    {


        foreach ($devis->getOuvrages() as $ouvrage) {
            dump($ouvrage);
        }
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $devisRepository->add($devis);
            return $this->redirectToRoute('app_affaire_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/devis/new.html.twig', [
            'devis' => $devis,
            'form' => $form,
            'demande' => $devis->getDemande(),
            'title' => "Création d'un devis - " . $devis->getTitre() . " " . $devis->getId(),
            'nav' => []
        ]);
    }

    #[Route('/ouvrage/import/{id}', name: 'app_affaire_ouvrage_import', methods: ['POST'])]
    public function importOuvrage(Request $request, EntityManagerInterface $entityManager, OuvrageRepository $ouvrageRepository, Devis $devis, DevisRepository $devisRepository): Response
    {

        $data = $request->request->all();


        $sum = 0;
        foreach ($data as $val) {
            $ouvrage = $ouvrageRepository->find($val);

            $clone = $ouvrage;

            $clone->setStatut('Copie');
            $clone->setCreateur($this->getUser());
            foreach ($ouvrage->getComposants() as $composant) {
                $entityManager->detach($clone);
                $clone->addComposant($composant);
                $composant->addOuvrage($ouvrage);
            }
            $entityManager->detach($clone);
            $ouvrageRepository->add($clone);
            $devis->addOuvrage($clone);
            $ouvrage->setDevis($devis);
            $ouvrageRepository->add($clone);
        }
        //  return new Response(json_encode($data));


        try {
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }


    #[Route('/modal/title/{id}', name: 'app_affaire_devis_modal_titre', methods: ['GET', 'POST'])]
    public function getModal(Request $request, Demande $demande, Environment $environment): Response
    {

        $response = new Response();

        $path = "affaire/devis/modal_titre.html.twig";

        if (!empty($path)) {

            try {
                $html = $environment->render($path, ['demande' => $demande]);
            } catch (LoaderError $e) {
                dd($e);
            } catch (RuntimeError $e) {
                dd($e);
            } catch (SyntaxError $e) {
                dd($e);
            }
            $response->setContent(json_encode(['code' => 200, 'message' => $html]));
        }
        return $response;
    }


    #[Route('/{id}', name: 'app_affaire_devis_delete', methods: ['POST'])]
    public function delete(Request $request, Devis $devi, DevisRepository $devisRepository, OuvrageRepository $ouvrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $devi->getId(), $request->request->get('_token'))) {
            foreach ($devi->getOuvrages() as $ouvrage) {
                $ouvrage->setDevis(null);
                $ouvrageRepository->add($ouvrage);
            }
            $devisRepository->remove($devi);
        }

        return $this->redirectToRoute('app_affaire_devis_index', [], Response::HTTP_SEE_OTHER);
    }
}
