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
    public function index(OuvrageRepository $ouvrageRepository): Response
    {
        return $this->render('affaire/bibliothequeDePrix/index.html.twig', [
            'ouvrages' => $ouvrageRepository->findAll(),
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

    #[Route('/ouvrage/new', name: 'app_affaire_ouvrage_new', methods: ['POST'])]
    public function new(Request $request,OuvrageRepository $ouvrageRepository): Response
    {

        $data =$request->request->all();
        $data = $data['ouvrage'];

        $ouvrage = new Ouvrage();
        $ouvrage->setCode($data['code']);
        $ouvrage->setDebourseHTCalcule($data['duht']);
        $ouvrage->setDenomination($data['denomination']);
        $ouvrage->setUnite($data['unite']);
        $ouvrage->setCreateur($this->getUser());
        try {
            $ouvrageRepository->add($ouvrage);
            return new Response(json_encode(['code'=>200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }


        return new Response(json_encode(['code'=>404]));
    }

    #[Route('/ouvrage/{id}', name: 'app_affaire_ouvrage_show', methods: ['GET'])]
    public function show(Request $request,Ouvrage $ouvrage, OuvrageRepository $ouvrageRepository): Response
    {

        return $this->render('affaire/bibliothequeDePrix/edit.html.twig', [
            'ouvrage' => $ouvrage,
            'title' => 'Ouvrage : '.$ouvrage->getDenomination(),
            'nav' => []
        ]);

    }


}
