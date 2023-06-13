<?php

namespace App\Controller\Affaire;

use App\Repository\UniteRepository;
use Exception;
use App\Entity\Unite;
use Twig\Environment;
use App\Entity\Demande;
use App\Entity\Affaire\Lot;
use App\Service\PdfService;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Entity\Affaire\Devis;
use App\Service\CalculService;
use App\Entity\Affaire\Ouvrage;
use App\Form\Affaire\DevisType;
use App\Entity\Affaire\Composant;
use App\Repository\UserRepository;
use App\Entity\Affaire\TypeComposant;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Affaire\LotRepository;
use Doctrine\ORM\OptimisticLockException;
use App\Repository\Affaire\DevisRepository;
use App\Repository\Affaire\OuvrageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Affaire\ComposantRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Affaire\TypeComposantRepository;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/affaire/devis')]
class DevisController extends AbstractController
{

    private $environment;
    private $em;
    private $unites;

    private $pdfService;
    private $calculService;

    public function __construct(Environment $environment, EntityManagerInterface $entityManagerInterface, PdfService $pdfService, CalculService $calculService)
    {
        $this->environment = $environment;
        $this->em = $entityManagerInterface;
        $this->pdfService = $pdfService;
        $this->unites = $entityManagerInterface->getRepository(Unite::class)->findAll();
        $this->calculService = $calculService;

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
    public function new(Demande $demande, Request $request, DevisRepository $devisRepository, TypeComposantRepository $typeComposantRepository, LotRepository $lotRepository, OuvrageRepository $ouvrageRepository, UniteRepository $uniteRepository): Response
    {


        $nom = $request->request->all()['devis']['nom'];

        $devis = new Devis();
        $devis->setTitre($nom);
        $devis->setDemande($demande);
        $devis->setCreateur($this->getUser());
        $devis->setFraisGeneraux(1);
        $devis->setMargeBeneficiaire(1);

        //Crée un lot directement dans un nouveau devis
        $lot = $this->initialiseLot($devis, $uniteRepository, $lotRepository);

        //Crée un ouvrage et ses composants dans le lot précédemment initialisé
        $this->initialiseOuvrage($devis, $lot, $ouvrageRepository, $typeComposantRepository, $lotRepository, $uniteRepository);

        $devisRepository->add($devis);
        return $this->redirectToRoute('app_affaire_devis_edit', ['id' => $devis->getId()], Response::HTTP_SEE_OTHER);

    }

    public function initialiseLot(Devis $devis, UniteRepository $uniteRepository, LotRepository $lotRepository)
    {
        // Crée un lot et l'ajoute au devis
        $lot = new Lot();
        $lot->setMarge($devis->getMarge());
        $uniteM2 = $uniteRepository->findOneByLabel('m2');
        $lot->setUnite($uniteM2);
        $elements = empty($devis->getElements()) ? [] : $devis->getElements();
        $lotRepository->save($lot);
        $el = ['id' => $lot->getId(), 'type' => 'lot', 'data' => []];
        $elements[] = $el;
        $devis->addLot($lot);
        $devis->setElements($elements);

        return $lot;
    }

    public  function initialiseOuvrage(Devis $devis, Lot $lot, OuvrageRepository $ouvrageRepository, TypeComposantRepository $typeComposantRepository, LotRepository $lotRepository, UniteRepository $uniteRepository)
    {
        $ouvrage = new Ouvrage();
        $ouvrage->setMarge($devis->getMarge());
        $ouvrage->setCreateur($this->getUser());
        $ouvrage->setUnite($lot->getUnite());
        $ouvrage->setUnite($uniteRepository->findOneByLabel('m2'));
        $ouvrage->setStatut('Copie');
        $parentId = $lot->getId();
        $elements = $devis->getElements();
        $this->em->persist($ouvrage);

        $typeComposants = $typeComposantRepository->findAll();
        $data = [];
        foreach ($typeComposants as $typeComposant) {
            $composant = new Composant();
            $composant->setUnite($uniteRepository->findOneByLabel('m2'));
            $composant->setTypeComposant($typeComposant);
            $composant->setDenomination($typeComposant->getTitre());
            if ($typeComposant->getCode() === "L") {
                $composant->setQuantite2(1);
                $composant->setUnite2($uniteRepository->findOneByLabel('J'));
            }
            $composant->setMarge($devis->getMarge());
            $composant->setStatut('copie');
            $this->em->persist($composant);
            $ouvrage->addComposant($composant);
            $this->em->flush();
            $data[] = [
                'id' => $composant->getId(),
                'type' => 'composant',
                'data' => [],
                'origine' => null,
            ];
        }

        $element = [
            'id' => $ouvrage->getId(),
            'type' => 'ouvrage',
            'data' => $data,
        ];
        $ouvrageRepository->add($ouvrage);

        if (!empty($parentId)) {
            $parent = [];
            $parent['id'] = $parentId;
            $parent['type'] = 'lot';
            $elements = $this->setParent($elements, $element, $parent);
            $this->em->persist($devis);
            $lot->addOuvrage($ouvrage);
            $lotRepository->add($lot);
        } else {
            $elements[] = $element;
            $devis->addOuvrage($ouvrage);
        }
        $devis->setElements($elements);
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
        $options = [];
        //dd($elements);

        foreach ($elements as $key => $element) {
            $path = "affaire/devis/" . $element['type'] . ".html.twig";
            if ($element['type'] == 'ouvrage') {
                $entity = $this->em->getRepository(Ouvrage::class)->find($element['id']);
                $options = $this->em->getRepository(Ouvrage::class)->findByStatut(null);
            } elseif ($element['type'] == 'lot') {
                $entity = $this->em->getRepository(Lot::class)->find($element['id']);
            } elseif ($element['type'] == 'composant') {
                $entity = $this->em->getRepository(Composant::class)->find($element['id']);
                if (!empty($element['origine'])) {
                    $options = $this->em->getRepository(Composant::class)->findComposantsByOuvrageId($element['origine']);

                } else {
                    $options = [];
                }
                // dd($options,$origine,$parent);
            }
            try {
                $htmlTMP = $this->environment->render($path, [$element['type'] => $entity, 'hasChild' => !empty($element['data']), 'key' => $key, 'hasParent' => $parent, 'options' => $options, 'unites' => $this->unites]);

                if (!empty($element['data'])) {
                    if ($element['type'] == 'lot') {
                        $htmlTMP = "<li>" . $htmlTMP . "<ul class='children' id='" . $element['type'] . "-ul-" . $element['id'] . "'>";
                        $htmlTMP .= $this->recursiveElements($element['data'], $element['id']);
                        $htmlTMP .= "</ul>";
                    } elseif ($element['type'] == 'ouvrage') {
                        $htmlTMP = "<li>" . $htmlTMP . "<ul class='children ouvrage-children' id='" . $element['type'] . "-ul-" . $element['id'] . "'>";
                        $htmlTMP .= $this->recursiveElements($element['data'], $element['id']);
                        $htmlTMP .= "</ul>";
                    }
                    $htmlTMP .= "</li>";
                    $html .= $htmlTMP;
                } elseif ($element['type'] != 'composant') {
                    $htmlTMP = "<li>" . $htmlTMP . "<ul class='children' id='" . $element['type'] . "-ul-" . $element['id'] . "'></ul></li>";
                    $html .= $htmlTMP;
                } else {
                    $html .= $htmlTMP;
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
        $cadenceDeRerefence = $this->em->getRepository(TypeComposant::class)->findOneByCode('M')->getCadence();

        $referer = $request->headers->get('referer');
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
            'cadenceDeRerefence' => $cadenceDeRerefence,
            'title' => "Création d'un devis - " . $devis->getTitre() . " " . $devis->getId(),
            'nav' => []
        ]);
    }

    #[Route('/calcul/edit/{id}', name: 'app_affaire_devis_calcul_edit', methods: ['GET', 'POST'])]
    public function editCalcul(Request $request, Devis $devis, DevisRepository $devisRepository): Response
    {

        $data = $request->request->all();
        $data = $data['devis'];
        $devis->setMarge($data['marge']);
        try {

            $devisRepository->add($devis);
            $data = $this->calculService->recursiveCalculBottom(['id' => $devis->getId(), 'type' => 'devis']);
            $data[] = $devis->__toArray();

            return new Response(json_encode(['code' => 200, 'data' => $data]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));

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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
                $composant->setOuvrage($clone);
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
                $html .= $environment->render($path, ["ouvrage" => $clone, 'hasParent' => $val['parentId'], 'unites' => $this->unites]);
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
        } catch (Exception $e) {
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
                $html = $environment->render($path, ['demande' => $demande, 'unites' => $this->unites]);
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
    public function newLot(Request $request, Environment $environment, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository, UniteRepository $uniteRepository): Response
    {
        $path = "affaire/devis/lot.html.twig";

        $data = $request->request->all();
        //dd($data);

        $lot = new Lot();
        $lot->setMarge($devis->getMarge());

        $uniteM2 = $uniteRepository->findOneByLabel('m2');
        $lot->setUnite($uniteM2);
        $html = "";

        $elements = empty($devis->getElements()) ? [] : $devis->getElements();

        try {
            $lotRepository->save($lot);
            $el = ['id' => $lot->getId(), 'type' => 'lot', 'data' => []];
            if (!empty($data['parentId']) and !empty($data['parentType'])) {
                $parent['id'] = $data['parentId'];
                $parent['type'] = $data['parentType'];
                $elements = $this->setParent($elements, $el, $parent);
                $lotParent = $lotRepository->find($data['parentId']);
                $lotParent->addSousLot($lot);
                $lotRepository->add($lotParent);

            } else {
                $elements[] = $el;
                $devis->addLot($lot);
            }
            $devis->setElements($elements);
            $html .= $environment->render($path, ["lot" => $lot, 'hasParent' => $data['parentId'], 'unites' => $this->unites]);
            $html = "<li>" . $html . "<ul class='children' id='lot-ul-" . $lot->getId() . "'></ul></li>";
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));

    }

    public function cloneElement($id, $type, LotRepository $lotRepository, OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository, $parent=null): array
    {

        if ($type == 'lot') {
            $lot = $lotRepository->find($id);
            $dupliquer = new Lot();
            $dupliquer->setDenomination($lot->getDenomination());
            $dupliquer->setCode($lot->getCode());
            $dupliquer->setDevis($lot->getDevis());
            $dupliquer->setUnite($lot->getUnite());
            $dupliquer->setDebourseTotalLot($lot->getDebourseTotalLot());
            $dupliquer->setPrixDeVenteHT($lot->getPrixDeVenteHT());
            $dupliquer->setQuantite($lot->getQuantite());
            $dupliquer->setMarge($lot->getMarge());
            $lotRepository->save($dupliquer);

            return ['id' => $dupliquer->getId(), 'type' => $type, "data" => []];
        } elseif ($type == "ouvrage") {
            $ouvrage = $ouvrageRepository->find($id);
            $dupliquer = new Ouvrage();
            $dupliquer->setDenomination($ouvrage->getDenomination());
            if ($parent != null) {
                $lot = $lotRepository->find($parent['id']);
                $dupliquer->setLot($lot);
            } else {
                $dupliquer->setLot($dupliquer->getLot());
            }
            $dupliquer->setStatut($ouvrage->getStatut());
            $dupliquer->setCode($ouvrage->getCode());
            $dupliquer->setUnite($ouvrage->getUnite());
            $dupliquer->setCreateur($this->getUser());
            $dupliquer->setOrigine($ouvrage->getOrigine());
            $dupliquer->setAttributs($ouvrage->getAttributs());
            $dupliquer->setTypeOuvrage($ouvrage->getTypeOuvrage());
            $dupliquer->setPoidsDeReference($ouvrage->getPoidsDeReference());
            $dupliquer->setTpsDeReference($ouvrage->getTpsDeReference());
            $dupliquer->setPourcentageTpsDeReference($ouvrage->getPourcentageTpsDeReference());
            $dupliquer->setPrixUnitaireDebourse(($ouvrage->getPrixUnitaireDebourse()) ? $ouvrage->getPrixUnitaireDebourse() : 0);
            $dupliquer->setMarge($ouvrage->getMarge());
            $dupliquer->setQuantite($ouvrage->getQuantite());
            $dupliquer->setDebourseHTCalcule(($ouvrage->getDebourseHTCalcule()) ? $ouvrage->getDebourseHTCalcule() : 0);
            $dupliquer->setPrixDeVenteHT($ouvrage->getPrixDeVenteHT());
            $ouvrageRepository->save($dupliquer);

            $element = ['id' => $dupliquer->getId(), 'type' => $type, "data" => []];

            foreach ($ouvrage->getComposants() as $composant) {
                $composantDupliquer = new Composant();
                $composantDupliquer->setDenomination($composant->getDenomination());
                $composantDupliquer->setTypeComposant($composant->getTypeComposant());
                if ($composantDupliquer->getTypeComposant()->getCode() === "L") {
                    $composantDupliquer->setQuantite2($composant->getQuantite2());
                    $composantDupliquer->setUnite2($composant->getUnite2());
                }
                $composantDupliquer->setUnite($composant->getUnite());
                $composantDupliquer->setStatut($composant->getStatut());
                $composantDupliquer->setDebourseUnitaireHT($composant->getDebourseUnitaireHT());
                $composantDupliquer->setMarge($composant->getMarge());
                $composantDupliquer->setQuantite($composant->getQuantite());
                $composantDupliquer->setDebourseTotalHT($composant->getDebourseTotalHT());
                $composantDupliquer->setOuvrage($dupliquer);
                $composantDupliquer->setSelection($composant->isSelection());
                $composantRepository->add($composantDupliquer);

                $element['data'][] = ['id' => $composantDupliquer->getId(), 'type' => 'composant', "data" => [], 'origine' => null];
            }

            return $element;
        }

        return false;
    }

    public function findElement($elements, $data, $lotRepository, $ouvrageRepository, $composantRepository)
    {
        foreach ($elements as $element) {
            if ($element['id'] == $data['id'] && $element['type'] == $data['type']) {
                $dupliquer = $this->cloneElement($data['id'], $data['type'], $lotRepository, $ouvrageRepository, $composantRepository);
                if ($data['type'] == 'lot') {
                    $path = "affaire/devis/lot.html.twig";
                    if (!empty($element['data'])) {
                        foreach ($element['data'] as $el) {
                            $dupliquer['data'][] = $this->cloneElement($el['id'], $el['type'], $lotRepository, $ouvrageRepository, $composantRepository, $dupliquer);
                        }
                    }
                }
                return $dupliquer;
            } else if (!empty($element['data'])) {
                $dupliquer = $this->findElement($element['data'], $data, $lotRepository, $ouvrageRepository, $composantRepository);
                if ($dupliquer) {
                    return $dupliquer;
                }
            }
        }
    }


    #[Route('/ouvrage/origine/add/{devis}/{id}/{origine}', name: 'app_affaire_devis_ouvrage_add_origine', methods: ['GET', 'POST'])]
    public function addOrigineToOuvrage(Devis $devis, Ouvrage $ouvrage, Ouvrage $origine, OuvrageRepository $ouvrageRepository, EntityManagerInterface $entityManager): Response
    {
        $ouvrage->setOrigine($origine->getId());
        $ouvrage->setDenomination($origine->getDenomination());
        $ouvrage->setCode($origine->getCode());
        $ouvrage->setUnite($origine->getUnite());
        $ouvrage->setCreateur($this->getUser());
        $ouvrage->setNote($origine->getNote());
        $ouvrage->setTypeDOuvrage($origine->getTypeDOuvrage());
        $ouvrage->setQuantite($origine->getQuantite());

        $elements = $devis->getElements();
        $parent = [
            'id' => $ouvrage->getId(),
            'type' => 'ouvrage',
            'data' => [],
        ];
        $html = "";
        foreach ($origine->getComposants() as $composant) {
            $clone = $composant;
            $clone->setCreateur($this->getUser());
            $clone->setStatut('Copie');
            $entityManager->detach($clone);
            $entityManager->getRepository(Composant::class)->add($clone);
            $clone->setOuvrage($ouvrage);
            $ouvrage->addComposant($clone);
            $entityManager->getRepository(Composant::class)->add($clone);

            $element = [
                'id' => $clone->getId(),
                'type' => 'composant',
                'data' => [],
                'origine' => $ouvrage->getId(),
            ];
            $elements = $this->setParent($elements, $element, $parent);
            $html .= $this->recursiveElements([$element], $ouvrage->getId());

        }
        $entityManager->getRepository(Ouvrage::class)->add($ouvrage);

        $ouvrage->setPrixDeVenteHT($ouvrage->getSommePrixDeVenteHTComposants());
        $ouvrage->setMarge($ouvrage->getSommePrixDeVenteHTComposants() / $ouvrage->getSommeDebourseTotalComposants());

        $devis->setElements($elements);

        try {
            //  $entityManager->getRepository(Devis::class)->add($devis);
            $data = $this->calculService->recursiveCalculTop(['id' => $ouvrage->getId(), 'type' => 'ouvrage']);
            $ouvrageRepository->save($ouvrage);

            $data[] = $ouvrage->__toArray();
            return new Response(json_encode(['code' => 200, 'data' => $data, 'html' => $html]));

        } catch (\Exception $e) {
            dd($e);
        }

    }


    #[Route('/ouvrage/new/{id}/{parentId}', name: 'app_affaire_devis_ouvrage_new', methods: ['GET', 'POST'])]
    public function newOuvrage(Devis $devis, $parentId = null, Request $request, Environment $environment, LotRepository $lotRepository, DevisRepository $devisRepository, OuvrageRepository $ouvrageRepository, TypeComposantRepository $typeComposantRepository, UniteRepository $uniteRepository): Response
    {


        $ouvrage = new Ouvrage();
        if (!empty($parentId)) {
            $lot = $lotRepository->find($parentId);
            $ouvrage->setMarge($lot->getMarge());
        } else {
            $ouvrage->setMarge($devis->getMarge());
        }
        $ouvrage->setCreateur($this->getUser());
        $ouvrage->setUnite($uniteRepository->findOneByLabel('m2'));
        $ouvrage->setStatut('Copie');
        $elements = $devis->getElements();
        $this->em->persist($ouvrage);

        $typeComposants = $typeComposantRepository->findAll();
        $data = [];
        foreach ($typeComposants as $typeComposant) {
            $composant = new Composant();
            $composant->setUnite($uniteRepository->findOneByLabel('m2'));
            if ($typeComposant->getCode() === "L"){
                $composant->setQuantite2(1);
                $composant->setUnite2($uniteRepository->findOneByLabel('J'));
            }
            if ($typeComposant->getCode() === "MA" || $typeComposant->getCode() === "MR"){
                $composant->setSelection(false);
            } else {
                $composant->setSelection(true);
            }
            $composant->setTypeComposant($typeComposant);
            $composant->setDenomination($typeComposant->getTitre());
            if ($composant->getDenomination() == "Location") {
                $composant->setQuantite2(1);
            }
            $composant->setMarge($ouvrage->getMarge());
            $composant->setStatut('copie');
            $this->em->persist($composant);
            $ouvrage->addComposant($composant);
            $this->em->flush();
            $data[] = [
                'id' => $composant->getId(),
                'type' => 'composant',
                'data' => [],
                'origine' => null,
            ];
        }

        try {
            $element = [
                'id' => $ouvrage->getId(),
                'type' => 'ouvrage',
                'data' => $data,
            ];
            $html = $this->recursiveElements([$element], $parentId);
            $ouvrageRepository->add($ouvrage);

            if (!empty($parentId)) {
                $parent = [];
                $parent['id'] = $parentId;
                $parent['type'] = 'lot';
                $elements = $this->setParent($elements, $element, $parent);
                $lot->addOuvrage($ouvrage);
                $lotRepository->add($lot);
                $ouvrage->setUnite($ouvrage->getLot()->getUnite());
            } else {
                $elements[] = $element;
                $devis->addOuvrage($ouvrage);
            }
            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html, 'idParent' => $parentId, 'id' => $ouvrage->getId()]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/composant/new/{id}/{parentId}/{origine}', name: 'app_affaire_devis_composant_new', methods: ['GET', 'POST'])]
    public function newComposant(Devis $devis, $parentId, $origine, Request $request, Environment $environment, OuvrageRepository $ouvrageRepository, DevisRepository $devisRepository, ComposantRepository $composantRepository): Response
    {


        // on crée un nouveau composant avec le statut copie
        $composant = new Composant();
        $composant->setCreateur($this->getUser());
        $composant->setStatut('Copie');

        // on recupere tout les elements du devis pour pouvoir les modifier et y ajouter des nouveaux elements
        $elements = $devis->getElements();

        try {
            // on sauvergade notre noveau element pour pouvoir recuperer l'id
            $composantRepository->add($composant);

            // on crée le tableau de notre nouveau element pour pouvoir l'ajouter au tablement elements de devis et créer son html
            $element = [
                'id' => $composant->getId(),
                'type' => 'composant',
                'origine' => $origine,
                'data' => []
            ];
            $html = $this->recursiveElements([$element], $parentId);

            if (!empty($parentId)) {
                $parent = [];
                $parent['id'] = $parentId;
                $parent['type'] = 'ouvrage';
                $elements = $this->setParent($elements, $element, $parent);
                $ouvrage = $ouvrageRepository->find($parentId);
                $ouvrage->addComposant($composant);
                $ouvrageRepository->add($ouvrage);

            } else {
                $elements[] = $element;
            }
            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html, 'idParent' => $parentId]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/dupliquer/element/{id}', name: 'app_affaire_element_dupliquer', methods: ['GET', 'POST'])]
    public function dupliquerElement(Request $request, Environment $environment, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository, OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository): Response
    {
        $data = $request->request->all();
        //dd($data);

        $elements = $devis->getElements();
        $dupliquer = $this->findElement($elements, $data, $lotRepository, $ouvrageRepository, $composantRepository);
        //dd([$dupliquer]);


        $html = $this->recursiveElements([$dupliquer], $data['idParent']);

        if (!empty($data['idParent'])) {
            $idParent = $data['idParent'];
            $parent = [];
            $parent['id'] = $data['idParent'];
            $parent['type'] = 'lot';
            $elements = $this->setParent($elements, $dupliquer, $parent);

            $dataTop = $this->calculService->recursiveCalculTop(['id' => $data['idParent'], 'type' => 'lot']);
        } else {
            $idParent = null;
            $elements[] = $dupliquer;
            $dataTop = $this->calculService->recursiveCalculTop(['id' => $data['id'], 'type' => 'lot']);
        }
        //dd($html);

        //dump($data,$devis);
        //dump($data);
        //die;
        try {

            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, 'data' => $dataTop, "html" => $html, 'idParent' => $idParent]));
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
        $lot->setDenomination($data['denomination']);
        key_exists('quantite', $data) ? $lot->setQuantite($data['quantite']) : "";
        key_exists('prix', $data) && is_numeric($data['prix']) ? $lot->setPrixDeVenteHT($data['prix']) : "";
        key_exists('marge', $data) ? $lot->setMarge($data['marge']) : "";
        key_exists('unite', $data) ? $lot->setUnite($this->em->getRepository(Unite::class)->find($data['unite'])) : "";

        try {

            $lotRepository->add($lot);

            $dataBottom = $this->calculService->recursiveCalculBottom(['id' => $lot->getId(), 'type' => 'lot']);
            $dataTop = $this->calculService->recursiveCalculTop(['id' => $lot->getId(), 'type' => 'lot']);
            $data = array_merge($dataBottom, $dataTop);
            $data[] = $lot->__toArray();

            return new Response(json_encode(['code' => 200, 'data' => $data]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
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
    public function deleteElement(Devis $devis, Request $request, Environment $environment, DevisRepository $devisRepository, LotRepository $lotRepository, OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository): Response
    {
        $element = $request->request->all();
        //dd($element);
        try {
            $data = [];
            if (!empty($element['id']) and !empty($element['type'])) {

                if ($element['type'] == 'composant') {
                    $composant = $composantRepository->find($element['id']);
                    $composant->setMarge(0);
                    $composant->setPrixDeVenteHT(0);
                    $composant->setQuantite(0);
                    $composant->setDebourseUnitaireHT(0);
                    $composantRepository->add($composant);
                } elseif ($element['type'] == 'ouvrage') {
                    $ouvrage = $ouvrageRepository->find($element['id']);
                    $ouvrage->setMarge(0);
                    $ouvrage->setPrixDeVenteHT(0);
                    $ouvrage->setQuantite(0);
                    $ouvrage->getComposants()->clear();

                } elseif ($element['type'] == 'lot') {
                    $lot = $lotRepository->find($element['id']);
                    $lot->setMarge(0);
                    $lot->setPrixDeVenteHT(0);
                    $lot->setQuantite(0);
                    $lot->getOuvrages()->clear();
                    $lot->getSousLots()->clear();
                }

                $data = $this->calculService->recursiveCalculTop(['id' => $element['id'], 'type' => $element['type']]);
                $elements = $devis->deleteInElements($element, $lotRepository, $ouvrageRepository, $composantRepository);
                $devis->setElements($elements);
                $devisRepository->add($devis);
            }

            return new Response(json_encode(['code' => 200, 'data' => $data]));
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
            /*  foreach ($devis->getOuvrage() as $ouvrage) {
                  $ouvrage->setDevis($devis);
                  $ouvrageRepository->add($ouvrage);
              }*/
            $devisRepository->remove($devis);
        }

        return $this->redirectToRoute('app_affaire_devis_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/pdf/{id}', name: 'app_affaire_devis_pdf', methods: ['POST', 'GET'])]
    public function createPdf(Request $request, Devis $devis, LotRepository $lotRepository, OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository): Response
    {
        $prixDevis = 0;

        $elementsDevis = $devis->getElements();

        $elements = [];

        foreach ($elementsDevis as $lotDevis) {
            $lot = $lotRepository->find($lotDevis['id']);
            $tableauLot = ['lot' => $lot, 'type' => 'lot', 'data' => []];

            $prixDevis += $lot->getPrixDeVenteHT();

            foreach ($lotDevis['data'] as $sousElementDevis) {
                if ($sousElementDevis['type'] == 'ouvrage') {

                    $ouvrage = $ouvrageRepository->find($sousElementDevis['id']);
                    $tableauLot['data'][] = ['ouvrage' => $ouvrage, 'type' => 'ouvrage', 'composants' => $composantRepository->findComposantsByOuvrageId($ouvrage->getId())];
                } elseif ($sousElementDevis['type'] == 'lot') {
                    $sousLot = $lotRepository->find($sousElementDevis['id']);
                    $tableauLot['data'][] = ['lot' => $sousLot, 'type' => 'lot', 'data' => []];

                    foreach ($sousElementDevis['data'] as $ouvrageDevis) {
                        $ouvrage = $ouvrageRepository->find($ouvrageDevis['id']);
                        $tableauLot['data'][count($tableauLot['data']) - 1]['data'][] = ['ouvrage' => $ouvrage, 'type' => 'ouvrage', 'composants' => $composantRepository->findComposantsByOuvrageId($ouvrage->getId())];

                    }
                }
            }

            $elements[] = $tableauLot;
        }

        $bodyTemplate1 = $this->environment->render('pdf/devis1.html.twig', ['devis' => $devis, 'prixDevis' => $prixDevis, 'page' => 1]);
        $bodyTemplate2 = $this->environment->render('pdf/devis2.html.twig', ['devis' => $devis, 'elements' => $elements, 'prixDevis' => $prixDevis, 'page' => 2]);
        $bodyTemplate3 = $this->environment->render('pdf/devis3.html.twig', ['devis' => $devis, 'page' => 3]);

        $name = $devis->getTitre();

        $this->pdfService->generateTemplate($bodyTemplate1);
        $this->pdfService->generateTemplatePaysage($bodyTemplate2);
        $this->pdfService->generateTemplate($bodyTemplate3);

        $pdf = $this->pdfService->generatePdf($name);

        $response = new Response($pdf);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $name . '.pdf'
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

}
