<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Composant;
use App\Entity\Affaire\Devis;
use App\Entity\Affaire\Lot;
use App\Entity\Affaire\Ouvrage;
use App\Entity\Affaire\SousLot;
use App\Entity\Demande;
use App\Form\Affaire\DevisType;
use App\Form\Affaire\TypeComposantType;
use App\Repository\Affaire\ComposantRepository;
use App\Repository\Affaire\DevisRepository;
use App\Repository\Affaire\OuvrageRepository;
use App\Repository\Affaire\TypeComposantRepository;
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

#[Route('/affaire/bibliothequeDePrix')]
class BibliothequeDePrixController extends AbstractController
{
    #[Route('/', name: 'app_affaire_bibliotheque_de_prix', methods: ['GET'])]
    public function index(OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository): Response
    {
        return $this->render('affaire/bibliothequeDePrix/index.html.twig', [
            'ouvrages' => $ouvrageRepository->findAll(),
            'composants' => $composantRepository->findAll(),
            'title' => 'Bibliotheque de prix',
            'nav' => []
        ]);
    }


    #[Route('/modal/ouvrage', name: 'app_affaire_modal_ouvrage', methods: ['GET', 'POST'])]
    public function modalOuvrage(Request $request, Environment $environment): Response
    {
        $response = new Response();

        $path = "affaire/bibliothequeDePrix/modal_ouvrage.html.twig";

        if (!empty($path)) {

            try {
                $html = $environment->render($path);
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


    #[Route('/modal/composant', name: 'app_affaire_modal_composant', methods: ['GET', 'POST'])]
    public function modalComposant(Request $request, Environment $environment, TypeComposantRepository $typeComposantRepository): Response
    {
        $response = new Response();

        $path = "affaire/bibliothequeDePrix/modal_composant.html.twig";

        if (!empty($path)) {

            try {
                $html = $environment->render($path, ["types" => $typeComposantRepository->findAll()]);
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

    #[Route('/modal/composant/liste/{id}', name: 'app_affaire_modal_composant_liste', methods: ['GET', 'POST'])]
    public function modalComposantListe(Request $request, Environment $environment, ComposantRepository $composantRepository, Ouvrage $ouvrage): Response
    {
        $response = new Response();

        $path = "affaire/bibliothequeDePrix/modal_composant_list.html.twig";

        $composants = $composantRepository->findAll();

        foreach ($composants as $key => $composant) {
            if ($ouvrage->getComposants()->contains($composant)) {
                unset($composants[$key]);
            }
        }

        if (!empty($path)) {
            try {
                $html = $environment->render($path, ["composants" => $composants]);
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


    #[Route('/ouvrage/new', name: 'app_affaire_ouvrage_new', methods: ['POST'])]
    public function new(Request $request, OuvrageRepository $ouvrageRepository): Response
    {

        $data = $request->request->all();
        $data = $data['ouvrage'];

        $ouvrage = new Ouvrage();
        $ouvrage->setCode($data['code']);
        $ouvrage->setDebourseHTCalcule($data['duht']);
        $ouvrage->setDenomination($data['denomination']);
        $ouvrage->setUnite($data['unite']);
        $ouvrage->setCreateur($this->getUser());
        try {
            $ouvrageRepository->add($ouvrage);
            return new Response(json_encode(['code' => 200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/ouvrage/edit/{id}', name: 'app_affaire_ouvrage_edit', methods: ['POST'])]
    public function edit(Request $request, Ouvrage $ouvrage, OuvrageRepository $ouvrageRepository): Response
    {

        $data = $request->request->all();
        $data = $data['ouvrage'];

        $ouvrage->setCode($data['code']);
        $ouvrage->setDebourseHTCalcule($data['duht']);
        $ouvrage->setDenomination($data['denomination']);
        $ouvrage->setUnite($data['unite']);
        $ouvrage->setNote($data['note']);
        try {
            $ouvrageRepository->add($ouvrage);
            return new Response(json_encode(['code' => 200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/composant/edit/{id}', name: 'app_affaire_composant_edit', methods: ['POST'])]
    public function editComposant(Request $request, Composant $composant, ComposantRepository $composantRepository): Response
    {

        $data = $request->request->all();
        $data = $data['composant'];

        $composant->setCode($data['code']);
        $composant->setDebourseUnitaireHT($data['duht']);
        $composant->setIntitule($data['intitule']);
        $composant->setUnite($data['unite']);
        $composant->setMarge(floatval($data['marge']));
        $composant->setPrixDeVente($composant->getMarge() * $composant->getDebourseUnitaireHT());
        $composant->setNote($data['note']);
        try {
            $composantRepository->add($composant);
            return new Response(json_encode(['code' => 200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/composant/new', name: 'app_affaire_composant_new', methods: ['POST'])]
    public function newComposant(Request $request, ComposantRepository $composantRepository, TypeComposantRepository $typeComposantRepository,OuvrageRepository $ouvrageRepository): Response
    {

        $data = $request->request->all();
        $data = $data['composant'];



        $composant = new Composant();
        $type = $typeComposantRepository->find($data['type']);
        $composant->setTypeComposant($type);
        $composant->setCode($data['code']);
        $composant->setDebourseUnitaireHT($data['duht']);
        $composant->setIntitule($data['intitule']);
        $composant->setUnite($data['unite']);
        $composant->setMarge(floatval($data['marge']));
        $composant->setPrixDeVente($composant->getMarge() * $composant->getDebourseUnitaireHT());
        $composant->setCreateur($this->getUser());

        if(key_exists('ouvrage',$data)){
            $ouvrage = $ouvrageRepository->find($data['ouvrage']);
            $composant->addOuvrage($ouvrage);
        }
        try {
            $composantRepository->add($composant);
            return new Response(json_encode(['code' => 200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }


    #[Route('/composant/import/{id}', name: 'app_affaire_composant_import', methods: ['POST'])]
    public function importComposant(Request $request, ComposantRepository $composantRepository, Ouvrage $ouvrage, OuvrageRepository $ouvrageRepository): Response
    {

        $data = $request->request->all();


        foreach ($data as $val) {
            $composant = $composantRepository->find($val);
            $ouvrage->addComposant($composant);
        }
        //  return new Response(json_encode($data));


        try {
            $ouvrageRepository->add($ouvrage);
            return new Response(json_encode(['code' => 200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }


    #[Route('/ouvrage/{id}', name: 'app_affaire_ouvrage_show', methods: ['GET'])]
    public function show(Ouvrage $ouvrage): Response
    {

        return $this->render('affaire/bibliothequeDePrix/edit.html.twig', [
            'ouvrage' => $ouvrage,
            'title' => 'Ouvrage : ' . $ouvrage->getDenomination(),
            'nav' => []
        ]);

    }

    #[Route('/composant/{id}', name: 'app_affaire_composant_show', methods: ['GET'])]
    public function showComposant(Composant $composant, TypeComposantRepository $typeComposantRepository): Response
    {

        return $this->render('affaire/bibliothequeDePrix/edit_composant.html.twig', [
            'composant' => $composant,
            'types' => $typeComposantRepository->findAll(),
            'title' => 'Composant : ' . $composant->getIntitule(),
            'nav' => []
        ]);

    }


}
