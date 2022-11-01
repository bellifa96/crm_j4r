<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Devis;
use App\Entity\Affaire\Lot;
use App\Entity\Affaire\Ouvrage;
use App\Entity\Affaire\SousLot;
use App\Entity\Demande;
use App\Form\Affaire\DevisType;
use App\Repository\Affaire\DevisRepository;
use App\Repository\Affaire\LotRepository;
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

    public function recursiveElements($elements)
    {
        $html = "";

        foreach ($elements as $key => $element) {
            $path = "affaire/devis/".$element['type'].".html.twig";
            if($element['type'] == 'ouvrage'){
                $entity = $this->em->getRepository(Ouvrage::class)->find($element['id']);
            }elseif($element['type'] == 'lot'){
                $entity = $this->em->getRepository(Lot::class)->find($element['id']);
            }

            try {
                $html .= $this->environment->render($path, ["ouvrages" => $entity,'hasChild'=>!empty($element['data'])]);
            } catch (LoaderError $e) {
                dd($e);
            } catch (RuntimeError $e) {
                dd($e);
            } catch (SyntaxError $e) {
                dd($e);
            }
            if (!empty($element['data'])) {
                $html .= $this->recursiveElements($element['data']);
                $html .= "</div>";
            } 
        }
        return $html;


    }

    #[Route('/{id}/edit', name: 'app_affaire_devis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devis $devis, DevisRepository $devisRepository): Response
    {


        dump($devis->getElements());
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);

      // dd($this->recursiveElements(!empty($devis->getElements()) ? $devis->getElements() : []));

        if ($form->isSubmitted() && $form->isValid()) {
            $devisRepository->add($devis);
            return $this->redirectToRoute('app_affaire_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/devis/new.html.twig', [
            'devis' => $devis,
            'form' => $form,
            'demande' => $devis->getDemande(),
            'html' => $this->recursiveElements(!empty($devis->getElements()) ? $devis->getElements() : []),
            'title' => "Création d'un devis - " . $devis->getTitre() . " " . $devis->getId(),
            'nav' => []
        ]);
    }



    public function setParent($elements,$el,$parent){
          
        foreach($elements as &$element){
            if($element['id']==$parent['id'] && $element['type']== $parent['type']){
                $element['data'] = $el;
            }elseif(empty($element['data'])){
                $this->setParent($element['data'],$el,$parent);
            }
        }
        return $elements;
    }

    #[Route('/ouvrage/import/{id}', name: 'app_affaire_ouvrage_import', methods: ['POST'])]
    public function importOuvrage(Request $request, Environment $environment, EntityManagerInterface $entityManager, OuvrageRepository $ouvrageRepository, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository): Response
    {

        $path = "affaire/devis/ouvrage.html.twig";

        $data = $request->request->all();


        $sum = 0;

        $ouvrages = [];

        $elements = empty($devis->getElements()) ? [] : $devis->getElements();


        foreach ($data as $val) {

            $el= ['id'=>$val['id'], 'type' => 'ouvrage', 'data'=>[]];

            $parent = [];
            if(!empty($val['parent']) and !empty($val['parentType']) ){
                $parent['id'] = $val['parent'] ;
                $parent['type'] = $val['parentType'] ;
                $elements = $this->setParent($elements,$el,$parent);
            }else{
                $elements[] = $el;
            }


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
            $ouvrageRepository->add($clone);
            $ouvrages[] = $clone;
      //      $elements[]["ouvrages"][$clone->getId()] = $clone;
        }

        try {
            $html = $environment->render($path, ["ouvrages" => $ouvrages]);
        } catch (LoaderError $e) {
            dd($e);
        } catch (RuntimeError $e) {
            dd($e);
        } catch (SyntaxError $e) {
            dd($e);
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
    public function newLot(Request $request, Environment $environment, LotRepository $lotRepository, Devis $devis): Response
    {
        $response = new Response();

        $path = "affaire/devis/lot.html.twig";


        $lot = new Lot();

    //    $devis->setElements($devis->getElements());

        if (!empty($path)) {

            try {
                $lotRepository->add($lot);
                $html = $environment->render($path, ["lot" => $lot]);
            } catch (LoaderError $e) {
                dd($e);
            } catch (RuntimeError $e) {
                dd($e);
            } catch (SyntaxError $e) {
                dd($e);
            }
            $response->setContent(json_encode(['code' => 200, 'message' => $html, 'lot' => $lot->getId()]));
        }
        return $response;

    }

    #[Route('/edit/lot/{id}', name: 'app_affaire_lot_edit', methods: ['POST'])]
    public function editLot(Request $request, Lot $lot, LotRepository $lotRepository): Response
    {

        $data = $request->request->all();
        $data = $data['lot'];

        $lot->setCode($data['code']);
        $lot->setTitre($data['titre']);
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
