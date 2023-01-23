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

    public function recursiveElements($elements): string
    {
        $html = "";
//        dd($elements);
        foreach ($elements as $key => $element) {
            $path = "affaire/devis/" . $element['type'] . ".html.twig";
            if ($element['type'] == 'ouvrage') {
                $entity = $this->em->getRepository(Ouvrage::class)->find($element['id']);
            } elseif ($element['type'] == 'lot') {
                $entity = $this->em->getRepository(Lot::class)->find($element['id']);
            }
            try {
                $html .= $this->environment->render($path, [$element['type'] => $entity, 'hasChild' => !empty($element['data']), 'key' => $key]);
                if (!empty($element['data'])) {
                    $html .= "<div class='children'>";
                    $html .= $this->recursiveElements($element['data']);
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
    public function edit(Request $request, Devis $devis, DevisRepository $devisRepository): Response
    {

//    dd($devis);
        //  dump($devis->getElements());
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);

//       dd($this->recursiveElements(!empty($devis->getElements()) ? $devis->getElements() : []));

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


    public function setParent($elements, $el, $parent)
    {

        foreach ($elements as &$element) {
            if ($element['id'] == $parent['id'] && $element['type'] == $parent['type']) {
                $element['data'][] = $el;
            } elseif (empty($element['data'])) {
                $this->setParent($element['data'], $el, $parent);
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
                $devis->setElements($elements);
                $html .= $environment->render($path, ["ouvrage" => $clone]);
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

    /*#[Route('/ouvrage/{id}', name: 'app_affaire_ouvrage_new', methods: ['GET', 'POST'])]
    public function newOuvrage(Request $request, Environment $environment, OuvrageRepository $ouvrageRepository, Devis $devis, DevisRepository $devisRepository): Response
    {
        $path = "affaire/devis/ouvrage.html.twig";

        $data = $request->request->all();

       // dd($data);

        $ouvrage = new Ouvrage();
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
        }


        try {
            $ouvrageRepository->save($ouvrage);
            $el= ['id'=>$ouvrage->getId(), 'type' => 'ouvrage', 'data'=>[]];
            if(!empty($data['parentId']) and !empty($data['parentType']) ){
                $parent['id'] = $data['parentId'] ;
                $parent['type'] = $data['parentType'] ;
                $elements = $this->setParent($elements,$el,$parent);
            }else {
                $elements[] = $el;
            }
            $devis->setElements($elements);
            $html .= $environment->render($path, ["ouvrage" => $ouvrage]);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));

    }*/

    #[Route('/lot/{id}', name: 'app_affaire_lot_new', methods: ['GET', 'POST'])]
    public function newLot(Request $request, Environment $environment, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository): Response
    {
        $path = "affaire/devis/lot.html.twig";

        $data = $request->request->all();
        dd($data);

        $lot = new Lot();
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
            $html .= $environment->render($path, ["lot" => $lot]);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));

    }

    public function cloneElement($id, $type, LotRepository $lotRepository,OuvrageRepository $ouvrageRepository): array
    {
        
        if ($type == 'lot') {
            $lot = $lotRepository->find($id);
            $dupliquer = new Lot();
            $dupliquer->setTitre($lot->getTitre());
            $dupliquer->setCode($lot->getCode());
            $lotRepository->save($dupliquer);

            return ['id' => $dupliquer->getId(), 'type' => $type,"data"=>[]];
        }elseif($type == "ouvrage"){
            $ouvrage = $ouvrageRepository->find($id);
            $dupliquer = new Ouvrage();
            $dupliquer->setDenomination($ouvrage->getDenomination());
            $dupliquer->setCode($ouvrage->getCode());
            $dupliquer->setUnite($ouvrage->getUnite());
            $dupliquer->setDebourseHTCalcule($ouvrage->getDebourseHTCalcule());
            $ouvrageRepository->save($dupliquer);

            return ['id' => $dupliquer->getId(), 'type' => $type,"data"=>[]];
        }
        return false;
    }


    #[Route('/dupliquer/lot/{id}', name: 'app_affaire_lot_dupliquer', methods: ['GET', 'POST'])]
    public function dupliquerLot(Request $request, Environment $environment, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository,OuvrageRepository $ouvrageRepository): Response
    {
        $path = "affaire/devis/lot.html.twig";

        $data = $request->request->all();
        //dd($data['data']);

        //$lot = $lotRepository->find($data['id']);
        //$dupliquer->setTitre($lot->getTitre());

        $elements = $devis->getElements();

        foreach ($elements as $element) {
            if ($element['id'] == $data['id'] && $element['type'] == $data['type']) {
                $dupliquer = $this->cloneElement($data['id'], $data['type'], $lotRepository,$ouvrageRepository);
                if(!empty($element['data'])){
                    foreach($element['data'] as $el){
                        $dupliquer['data'][]= $this->cloneElement($el['id'], $el['type'], $lotRepository,$ouvrageRepository);
                    }
                }
            }
        }
        $html = $this->recursiveElements([$dupliquer]);

        $elements[]=$dupliquer;

        //dd($html);

        //dump($data,$devis);
        //dump($data);
        //die;
        try {
         
            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html]));
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

    #[Route('/delete/element/{id}', name: 'app_affaire_devis_element_delete', methods: ['POST', 'GET'])]
    public function deleteLot(Devis $devis, Request $request, Environment $environment, DevisRepository $devisRepository): Response
    {
        $lot = $request->request->all();
        try {
            if (!empty($lot['id']) and !empty($lot['type'])) {
                $elements = $devis->deleteInElements($lot);
                $devis->setElements($elements);
            }
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
