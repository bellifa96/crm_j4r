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
use App\Repository\Affaire\SousLotRepository;
use App\Repository\Affaire\TypeComposantRepository;
use DeepCopy\DeepCopy;
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

#[Route('/affaire/bibliothequeDePrix')]
class BibliothequeDePrixController extends AbstractController
{
    #[Route('/', name: 'app_affaire_bibliotheque_de_prix', methods: ['GET'])]
    public function index(OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository): Response
    {

        $ouvrages = $ouvrageRepository->findAll();
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

    #[Route('/modal/ouvrage/liste/{id}', name: 'app_affaire_modal_ouvrage_liste', methods: ['GET', 'POST'])]
    public function modalOuvrageListe(Request $request, Environment $environment, OuvrageRepository $ouvrageRepository, Devis $devis): Response
    {
        $response = new Response();

        $path = "affaire/bibliothequeDePrix/modal_ouvrage_list.html.twig";

        $ouvrages = $ouvrageRepository->findAll();

        foreach ($ouvrages as $key => $ouvrage) {
            if ($devis->getOuvrages()->contains($ouvrage)) {
                unset($ouvrages[$key]);
            }
        }

        if (!empty($path)) {
            try {
                $html = $environment->render($path, ["ouvrages" => $ouvrages]);
            } catch (LoaderError $e) {
                dd($e);
            } catch (RuntimeError $e) {
                dd($e);
            } catch (SyntaxError $e) {
                dd($e);
            }
            $response->setContent(json_encode(['code' => 200, 'html' => $html]));
        }
        return $response;
    }


    #[Route('/modal/ouvrage/dupliquer/{id}', name: 'app_affaire_modal_ouvrage_dupliquer', methods: ['GET', 'POST'])]
    public function modalOuvrageDupliquer(Request $request, Environment $environment, Ouvrage $ouvrage,): Response
    {
        $response = new Response();

        $path = "affaire/bibliothequeDePrix/modal_ouvrage_dupliquer.html.twig";

        if (!empty($path)) {

            try {
                $html = $environment->render($path, ["ouvrage" => $ouvrage]);
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


    #[Route('/modal/composant/dupliquer/{id}', name: 'app_affaire_modal_composant_dupliquer', methods: ['GET', 'POST'])]
    public function modalComposantDupliquer(Request $request, Environment $environment, TypeComposantRepository $typeComposantRepository, Composant $composant): Response
    {
        $response = new Response();

        $path = "affaire/bibliothequeDePrix/modal_composant_dupliquer.html.twig";

        if (!empty($path)) {

            try {
                $html = $environment->render($path, ["types" => $typeComposantRepository->findAll(), "composant" => $composant]);
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
    public function newComposant(Request $request, ComposantRepository $composantRepository, TypeComposantRepository $typeComposantRepository, OuvrageRepository $ouvrageRepository): Response
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

        if (key_exists('ouvrage', $data)) {
            $sum = 0;
            $ouvrage = $ouvrageRepository->find($data['ouvrage']);
            $composant->addOuvrage($ouvrage);
            foreach ($ouvrage->getComposants() as $val) {
                $sum += $val->getPrixDeVente();
            }
            $ouvrage->setPrixUnitaireDebourse($sum);
            $ouvrageRepository->add($ouvrage);
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


        $sum = 0;
        foreach ($data as $val) {
            $composant = $composantRepository->find($val);
            $ouvrage->addComposant($composant);
            $sum += $composant->getPrixDeVente();
        }
        $ouvrage->setPrixUnitaireDebourse($sum);

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


    #[Route('/ouvrage/{id}', name: 'app_affaire_ouvrage_show_alex', methods: ['GET'])]
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

    #[Route('/composant/quantite/{id}', name: 'app_affaire_composant_quantite', methods: ['GET', 'POST'])]
    public function quantiteComposant(Request $request, Ouvrage $ouvrage, OuvrageRepository $ouvrageRepository): Response
    {


        $data = $request->request->all()['composant'];

        $quantite = $ouvrage->getQuantite();
        $quantite[$data['id']] = $data['quantite'];

        $ouvrage->setQuantite($quantite);

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

        #[Route('/composant/dupliquer/{id}', name: 'app_affaire_composant_dupliquer', methods: ['GET', 'POST'])]
    public function dupliquerComposant(Request $request, Composant $composant, ComposantRepository $composantRepository, EntityManagerInterface $entityManager, TypeComposantRepository $typeComposantRepository): Response
    {


        $data = $request->request->all()['composant'];

        $clone = $composant;


        $type = $typeComposantRepository->find($data['type']);
        $clone->setTypeComposant($type);
        $clone->setCode($data['code']);
        $clone->setDebourseUnitaireHT($data['DUHT']);
        $clone->setIntitule($data['intitule']);
        $clone->setUnite($data['unite']);
        $clone->setMarge(floatval($data['marge']));
        $clone->setPrixDeVente($clone->getMarge() * $clone->getDebourseUnitaireHT());
        $clone->setCreateur($this->getUser());

        $entityManager->detach($clone);

        $composantRepository->add($clone);

        return $this->redirectToRoute('app_affaire_bibliotheque_de_prix', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/ouvrage/{id}', name: 'app_affaire_ouvrage_show', methods: ['GET'])]
    public function showOuvrage(Ouvrage $ouvrage, OuvrageRepository $ouvrageRepository): Response
    {

        return $this->render('affaire/bibliothequeDePrix/edit_composant.html.twig', [
            'composant' => $ouvrage,
            'types' => $ouvrageRepository->findAll(),
            'title' => 'Ouvrage : ' . $ouvrage->getDenomination(),
            'nav' => []
        ]);

    }

    #[Route('/ouvrage/import/{id}', name: 'app_affaire_ouvrage_import', methods: ['POST'])]
    public function importOuvrage(Request $request, OuvrageRepository $ouvrageRepository, Devis $devis, DevisRepository $devisRepository): Response
    {

        $data = $request->request->all();


        $sum = 0;
        foreach ($data as $val) {
            $ouvrage = $ouvrageRepository->find($val);
            $devis->addOuvrage($ouvrage);
            $sum += $ouvrage->getPrixDeVenteHT();
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

    #[Route('/ouvrage/dupliquer/{id}', name: 'app_affaire_ouvrage_dupliquer', methods: ['GET', 'POST'])]
    public function dupliquerOuvrage(Request $request, Ouvrage $ouvrage, OuvrageRepository $ouvrageRepository, EntityManagerInterface $entityManager, ComposantRepository $composantRepository): Response
    {


        $data = $request->request->all()['ouvrage'];

        $clone = $ouvrage;


        $clone->setCode($data['code']);
        $clone->setDebourseHTCalcule($data['DUHT']);
        $clone->setDenomination($data['denomination']);
        $clone->setUnite($data['unite']);
        $clone->setCreateur($this->getUser());
        foreach ($ouvrage->getComposants() as $composant) {
            $entityManager->detach($clone);
            $clone->addComposant($composant);
            $composant->addOuvrage($ouvrage);

        }


        $entityManager->detach($clone);

        $ouvrageRepository->add($clone);


        //    dd($clone);


        //    $entityManager->flush();


        return $this->redirectToRoute('app_affaire_bibliotheque_de_prix', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/ouvrage/{id}', name: 'app_affaire_ouvrage_delete', methods: ['POST'])]
    public function delete(Request $request, Ouvrage $ouvrage, OuvrageRepository $ouvrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ouvrage->getId(), $request->request->get('_token'))) {
            $ouvrageRepository->remove($ouvrage);
        }

        return $this->redirectToRoute('app_affaire_bibliotheque_de_prix', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/composant/{id}', name: 'app_affaire_composant_delete', methods: ['POST'])]
    public function deleteComposant(Request $request, Composant $composant, ComposantRepository $composantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $composant->getId(), $request->request->get('_token'))) {
            $composantRepository->remove($composant);
        }

        return $this->redirectToRoute('app_affaire_bibliotheque_de_prix', [], Response::HTTP_SEE_OTHER);
    }


}
