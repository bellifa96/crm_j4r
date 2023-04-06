<?php

namespace App\Controller\Affaire;

use App\Entity\User;
use Twig\Environment;
use App\Entity\Demande;
use App\Form\DemandeType;
use App\Entity\Affaire\Lot;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Entity\Affaire\Devis;
use Doctrine\ORM\ORMException;
use App\Entity\Affaire\Ouvrage;
use App\Entity\Affaire\SousLot;
use App\Form\Affaire\DevisType;
use App\Entity\Affaire\Composant;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Affaire\LotRepository;
use Doctrine\ORM\OptimisticLockException;
use App\Repository\Affaire\DevisRepository;
use App\Repository\Affaire\OuvrageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Affaire\ComposantRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/affaire/devis')]
class DevisController extends AbstractController
{

    private $environment;
    private $em;

    public function __construct(Environment $environment, EntityManagerInterface $entityManagerInterface)
    {
        $this->environment = $environment;
        $this->em = $entityManagerInterface;
    }

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
        $devis->setCreateur($this->getUser());
        $devis->setFraisGeneraux(1);
        $devis->setMargeBeneficiaire(1);
        $devisRepository->add($devis);
        return $this->redirectToRoute('app_affaire_devis_edit', ['id' => $devis->getId()], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{id}', name: 'app_affaire_devis_show', methods: ['GET'])]
    public function show(Devis $devis, Request $request, UserRepository $userRepository): Response
    {
        $data = $request->query->all();
        $referer = $request->headers->get('referer');

        /*$form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);*/

        $users = $userRepository->findAll();

        return $this->render('affaire/devis/show.html.twig', [
            'devis' => $devis,
            'title' => 'Devis N° ' . $devis->getId(),
            'users' => $users,
            //'form' => $form->createView(),
            'referer' => $referer,
            'nav' => []
        ]);
    }

    public function recursiveElements($elements, $parent = null): string
    {
        $html = "";
//        dd($elements);
        foreach ($elements as $key => $element) {
            $path = "affaire/devis/" . $element['type'] . ".html.twig";
            if ($element['type'] == 'ouvrage') {
                $entity = $this->em->getRepository(Ouvrage::class)->find($element['id']);
            } elseif ($element['type'] == 'lot') {
                $entity = $this->em->getRepository(Lot::class)->find($element['id']);
            }elseif($element['type'] == 'composant'){
                $entity = $this->em->getRepository(Composant::class)->find($element['id']);
            }
            try {
                $html .= $this->environment->render($path, [$element['type'] => $entity, 'hasChild' => !empty($element['data']), 'key' => $key, 'hasParent' => $parent]);
                if (!empty($element['data']) && $element['type'] == 'lot') {
                    $html .= "<div class='children' parent='lot-" . $element['id'] . "'>";
                    $html .= $this->recursiveElements($element['data'], $element['id']);
                    $html .= "</div>";
                }elseif(!empty($element['data']) && $element['type'] == 'ouvrage'){
                    $html .= "<div class='children' parent='ouvrage-" . $element['id'] . "'>";
                    $html .= $this->recursiveElements($element['data'], $element['id']);
                    $html .= "</div>";
                }
            } catch (LoaderError $e) {
                dd($e);
            } catch (RuntimeError $e) {
                dd($e);
            } catch (SyntaxError $e) {
                dd($e);
            }
        }
        return $html;


    }

    #[Route('/{id}/edit', name: 'app_affaire_devis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devis $devis, DevisRepository $devisRepository, UserRepository $userRepository): Response
    {

//    dd($devis);
        //  dump($devis->getElements());
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);

        $users = $userRepository->findAll();

        $referer = $request->headers->get('referer');

//       dd($this->recursiveElements(!empty($devis->getElements()) ? $devis->getElements() : []));

        if ($form->isSubmitted() && $form->isValid()) {
            $devisRepository->add($devis);
            return $this->redirectToRoute('app_affaire_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/devis/new.html.twig', [
            'devis' => $devis,
            'form' => $form,
            'users' => $users,
            'referer' => $referer,
            'demande' => $devis->getDemande(),
            'html' => $this->recursiveElements(!empty($devis->getElements()) ? $devis->getElements() : []),
            'title' => "Création d'un devis - " . $devis->getTitre() . " " . $devis->getId(),
            'nav' => []
        ]);
    }

    #[Route('/user/import/{id}', name: 'app_affaire_referent_import', methods: ['GET', 'POST'])]
    public function importReferent(Request $request, Devis $devis, DevisRepository $devisRepository, UserRepository $userRepository): Response
    {

        $data = $request->request->all();
        //dd($data);
        $referents = [];


        foreach ($data as $val) {

            $user = $userRepository->find($val['id']);
            $us = ['id' => $user->getId(), 'nom' => $user->getLastname(), 'prenom' => $user->getFirstname()];
            $referents[] = $us;
            $devis->addReferent($user);
        }

        try {
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "referents" => $referents]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/user/delete/{id}', name: 'app_affaire_referent_delete', methods: ['GET', 'POST'])]
    public function deleteReferent(Request $request, Devis $devis, DevisRepository $devisRepository, UserRepository $userRepository): Response
    {

        $data = $request->request->all();
        //dd($data);

        $user = $userRepository->find($data['id']);

        try {
            $devis->removeReferent($user);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, 'idReferent' => $user->getId()]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));
    }


    public function setParent($elements, $el, $parent)
    {
        foreach ($elements as &$element) {
            //dd($parent,$element['data']);
            if ($element['id'] == $parent['id'] && $element['type'] == $parent['type']) {
                $element['data'][] = $el;
            } elseif (!empty($element['data'])) {
                $element['data'] = $this->setParent($element['data'], $el, $parent);
            }
        }
        return $elements;
    }

    #[Route('/ouvrage/import/{id}', name: 'app_affaire_ouvrage_import', methods: ['POST'])]
    public function importOuvrage(Request $request, Environment $environment, EntityManagerInterface $entityManager, OuvrageRepository $ouvrageRepository, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository): Response
    {

        $path = "affaire/devis/ouvrage.html.twig";

        $data = $request->request->all();
        //dd($data);


        $sum = 0;

        $ouvrages = [];
        $html = "";

        $elements = empty($devis->getElements()) ? [] : $devis->getElements();


        foreach ($data as $val) {

            $ouvrage = $ouvrageRepository->find($val['id']);
            $clone = $ouvrage;

            $clone->setStatut('Copie');
            $clone->setCreateur($this->getUser());
            foreach ($ouvrage->getComposants() as $composant) {
                $entityManager->detach($clone);
                $clone->addComposant($composant);
                $composant->addOuvrage($clone);
            }
            $entityManager->detach($clone);
            $ouvrageRepository->add($clone);

            $el = ['id' => $clone->getId(), 'type' => 'ouvrage', 'data' => []];

            $parent = [];
            if (!empty($val['parentId']) and !empty($val['parentType'])) {
                $parent['id'] = $val['parentId'];
                $parent['type'] = $val['parentType'];
                $elements = $this->setParent($elements, $el, $parent);
            } else {
                $elements[] = $el;
            }

            try {
                $this->getPrix($elements, $ouvrageRepository, $lotRepository);
                $devis->setElements($elements);
                $html .= $environment->render($path, ["ouvrage" => $clone, 'hasParent' => $val['parentId']]);
            } catch (LoaderError $e) {
                dd($e);
            } catch (RuntimeError $e) {
                dd($e);
            } catch (SyntaxError $e) {
                dd($e);
            }
        }


        try {
            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html]));
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

    #[Route('/lot/{id}', name: 'app_affaire_lot_new', methods: ['GET', 'POST'])]
    public function newLot(Request $request, Environment $environment, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository): Response
    {
        $path = "affaire/devis/lot.html.twig";

        $data = $request->request->all();
        //dd($data);

        $lot = new Lot();
        $lot->setMarge(1);
        $html = "";

        $elements = empty($devis->getElements()) ? [] : $devis->getElements();

        //dump($data,$devis);
        //dump($data);
        //die;
        //foreach ($elements as $val) {

        //}

        /*$parent = [];
        if(!empty($val['parentId']) and !empty($val['parentType']) ){
            $parent['id'] = $val['parentId'] ;
            $parent['type'] = $val['parentType'] ;
            $elements = $this->setParent($elements,$el,$parent);
        }else{
            $elements[] = $el;
        }*/


        try {
            $lotRepository->save($lot);
            $el = ['id' => $lot->getId(), 'type' => 'lot', 'data' => []];
            if (!empty($data['parentId']) and !empty($data['parentType'])) {
                $parent['id'] = $data['parentId'];
                $parent['type'] = $data['parentType'];
                $elements = $this->setParent($elements, $el, $parent);
            } else {
                $elements[] = $el;
            }
            $devis->setElements($elements);
            $html .= $environment->render($path, ["lot" => $lot, 'hasParent' => $data['parentId']]);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));

    }

    public function cloneElement($id, $type, LotRepository $lotRepository, OuvrageRepository $ouvrageRepository): array
    {

        if ($type == 'lot') {
            $lot = $lotRepository->find($id);
            $dupliquer = new Lot();
            $dupliquer->setTitre($lot->getTitre());
            $dupliquer->setCode($lot->getCode());
            $dupliquer->setPrixHT($lot->getPrixHT());
            $dupliquer->setQuantite($lot->getQuantite());
            $dupliquer->setMarge($lot->getMarge());
            $lotRepository->save($dupliquer);

            return ['id' => $dupliquer->getId(), 'type' => $type, "data" => []];
        } elseif ($type == "ouvrage") {
            $ouvrage = $ouvrageRepository->find($id);
            $dupliquer = new Ouvrage();
            $dupliquer->setDenomination($ouvrage->getDenomination());
            $dupliquer->setCode($ouvrage->getCode());
            $dupliquer->setUnite($ouvrage->getUnite());
            $dupliquer->setPrixUnitaireDebourse(($ouvrage->getPrixUnitaireDebourse()) ? $ouvrage->getPrixUnitaireDebourse() : 0);
            $dupliquer->setMarge($ouvrage->getMarge());
            $dupliquer->setQuantite($ouvrage->getQuantite());
            $dupliquer->setDebourseHTCalcule($ouvrage->getDebourseHTCalcule());
            $ouvrageRepository->save($dupliquer);

            return ['id' => $dupliquer->getId(), 'type' => $type, "data" => []];
        }
        return false;
    }

    public function findElement($elements, $data, $lotRepository, $ouvrageRepository)
    {
        foreach ($elements as $element) {
            if ($element['id'] == $data['id'] && $element['type'] == $data['type']) {
                $dupliquer = $this->cloneElement($data['id'], $data['type'], $lotRepository, $ouvrageRepository);
                if ($data['type'] == 'lot') {
                    $path = "affaire/devis/lot.html.twig";
                    if (!empty($element['data'])) {
                        foreach ($element['data'] as $el) {
                            $dupliquer['data'][] = $this->cloneElement($el['id'], $el['type'], $lotRepository, $ouvrageRepository);
                        }
                    }
                } elseif ($data['type'] == 'ouvrage') {
                    $path = "affaire/devis/ouvrage.html.twig";
                }
                return $dupliquer;
            } else if (!empty($element['data'])) {
                $dupliquer = $this->findElement($element['data'], $data, $lotRepository, $ouvrageRepository);
                if ($dupliquer) {
                    return $dupliquer;
                }
            }
        }
    }


    #[Route('/ouvrage/new/{id}/{parentId}', name: 'app_affaire_devis_ouvrage_new', methods: ['GET', 'POST'])]
    public function newOuvrage(Devis $devis,$parentId = null,Request $request, Environment $environment, LotRepository $lotRepository, DevisRepository $devisRepository, OuvrageRepository $ouvrageRepository): Response
    {


        
        $ouvrage = new Ouvrage();
        $ouvrage->setMarge(1);
        $ouvrage->setCreateur($this->getUser());
        $elements = $devis->getElements();

        try {
            $ouvrageRepository->add($ouvrage);
            $element = [
                'id'=>$ouvrage->getId(),
                'type'=>'ouvrage',
                'data'=> []
            ];
            $html = $this->recursiveElements([$element]);

            if (!empty($parentId)) {
                $parent = [];
                $parent['id'] = $parentId;
                $parent['type'] = 'lot';
                $elements = $this->setParent($elements, $element, $parent);
            }else {
                $elements[] = $element;
            }
            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html, 'idParent' => $parentId]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/composant/new/{id}/{parentId}', name: 'app_affaire_devis_composant_new', methods: ['GET', 'POST'])]
    public function newComposant(Devis $devis,$parentId = null,Request $request, Environment $environment, LotRepository $lotRepository, DevisRepository $devisRepository, ComposantRepository $composantRepository): Response
    {


        
        $composant = new Composant();
        $composant->setMarge(1);
        $composant->setCreateur($this->getUser());
        $elements = $devis->getElements();

        try {
            $composantRepository->add($composant);
            $element = [
                'id'=>$composant->getId(),
                'type'=>'composant',
                'data'=> []
            ];
            $html = $this->recursiveElements([$element]);

            if (!empty($parentId)) {
                $parent = [];
                $parent['id'] = $parentId;
                $parent['type'] = 'ouvrage';
                $elements = $this->setParent($elements, $element, $parent);
            }else {
                $elements[] = $element;
            }
            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html, 'idParent' => $parentId]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/dupliquer/element/{id}', name: 'app_affaire_element_dupliquer', methods: ['GET', 'POST'])]
    public function dupliquerElement(Request $request, Environment $environment, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository, OuvrageRepository $ouvrageRepository): Response
    {
        $data = $request->request->all();
        //dd($data);

        //$lot = $lotRepository->find($data['id']);
        //$dupliquer->setTitre($lot->getTitre());

        $elements = $devis->getElements();
        $dupliquer = $this->findElement($elements, $data, $lotRepository, $ouvrageRepository);


        $html = $this->recursiveElements([$dupliquer]);

        if (!empty($data['idParent'])) {
            $parent = [];
            $parent['id'] = $data['idParent'];
            $parent['type'] = 'lot';
            $elements[] = $this->setParent($elements, $dupliquer, $parent);
        }else {
            $elements[] = $dupliquer;
        }



        //dd($html);

        //dump($data,$devis);
        //dump($data);
        //die;
        try {

            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html, 'idParent' => $data['idParent']]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/edit/lot/{id}', name: 'app_affaire_lot_edit', methods: ['POST'])]
    public function editLot(Request $request, Lot $lot, LotRepository $lotRepository): Response
    {

        $data = $request->request->all();
        $data = $data['lot'];

        $lot->setCode($data['code']);
        $lot->setTitre($data['titre']);
        key_exists('quantite', $data) ? $lot->setQuantite($data['quantite']) : $lot->setQuantite(null);
        key_exists('prix', $data) ? $lot->setPrixHT($data['prix']) : $lot->setPrixHT(null);
        try {
            $lotRepository->add($lot);
            return new Response(json_encode(['code' => 200, 'lot' => $lot->getId()]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (ORMException $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    public function getPrix($elements, $ouvrageRepository, $lotRepository): float
    {
        $prixHT = 0;


        //dd($elements);
        foreach ($elements as $element) {
            if ($element['type'] == 'lot') {
                $lotPrixHT = $this->getPrix($element['data'], $ouvrageRepository, $lotRepository);

                $lot = $lotRepository->find($element['id']);
                $lot->setPrixHT($lotPrixHT);
                $prixHT += $lotPrixHT;
            } elseif ($element['type'] == 'ouvrage') {
                $ouvrage = $ouvrageRepository->find($element['id']);
                $prixHT += $ouvrage->getDebourseHTCalcule();
            }
        }
        return $prixHT;
    }


    #[Route('/delete/element/{id}', name: 'app_affaire_devis_element_delete', methods: ['POST', 'GET'])]
    public function deleteElement(Devis $devis, Request $request, Environment $environment, DevisRepository $devisRepository, LotRepository $lotRepository, OuvrageRepository $ouvrageRepository): Response
    {
        $element = $request->request->all();
        //dd($element);
        try {
            if (!empty($element['id']) and !empty($element['type'])) {
                $elements = $devis->deleteInElements($element, $lotRepository, $ouvrageRepository);
                $devis->setElements($elements);
            }
            $this->getPrix($elements, $ouvrageRepository, $lotRepository);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/{id}', name: 'app_affaire_devis_delete', methods: ['POST'])]
    public function delete(Request $request, Devis $devis, DevisRepository $devisRepository, OuvrageRepository $ouvrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $devis->getId(), $request->request->get('_token'))) {
            foreach ($devis->getOuvrages() as $ouvrage) {
                $ouvrage->setDevis($devis);
                $ouvrageRepository->add($ouvrage);
            }
            $devisRepository->remove($devis);
        }

        return $this->redirectToRoute('app_affaire_devis_index', [], Response::HTTP_SEE_OTHER);
    }
}
