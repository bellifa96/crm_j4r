<?php

namespace App\Controller\Affaire;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Entity\Affaire\Devis;
use App\Service\CalculService;
use App\Entity\Affaire\Ouvrage;
use App\Entity\Affaire\Composant;
use App\Entity\Affaire\TableDePrix;
use App\Entity\Affaire\TypeOuvrage;
use App\Repository\UniteRepository;
use App\Entity\Affaire\AttributOuvrage;
use App\Entity\Affaire\CategorieOuvrage;
use App\Entity\Affaire\TypeComposant;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use App\Repository\Affaire\OuvrageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Affaire\ComposantRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Affaire\TableDePrixRepository;
use App\Repository\Affaire\TypeOuvrageRepository;
use App\Repository\Affaire\TypeComposantRepository;
use App\Repository\Affaire\AttributOuvrageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/affaire/bibliothequeDePrix')]
class BibliothequeDePrixController extends AbstractController
{

    private $unites;
    private $uniteRepository;
    private $calculService;

                    
    public function __construct(UniteRepository $uniteRepository,CalculService $calculService){
        $this->uniteRepository = $uniteRepository;
        $this->unites = $uniteRepository->findAll();
        $this->calculService = $calculService;

    }

    #[Route('/', name: 'app_affaire_bibliotheque_de_prix', methods: ['GET'])]
    public function index(OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository, TypeComposantRepository $typeComposantRepository, TypeOuvrageRepository $typeOuvrageRepository, TableDePrixRepository $tableDePrixRepository): Response
    {

        $ouvrages = $ouvrageRepository->findByStatut(null);
        $composants = $composantRepository->findByStatut(null);

        foreach($composants as $composant){
            if(empty($composant->getDenomination())){
                $composant->setDenomination($composant->getTypeComposant()->getTitre());
                $composantRepository->add($composant);
            }
        }

        return $this->render('affaire/bibliothequeDePrix/index.html.twig', [
            'ouvrages' => $ouvrages,
            'composants' => $composants,
            'typeComposants' => $typeComposantRepository->findAll(),
            'typeOuvrages' => $typeOuvrageRepository->findAll(),
            'tableDePrix' => $tableDePrixRepository->findAll(),
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
                $html = $environment->render($path,['unites'=>$this->unites]);
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
                $html = $environment->render($path, ["types" => $typeComposantRepository->findByStatut(null),'unites'=>$this->unites]);
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

        $composants = $composantRepository->findByStatut(null);

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

    #[Route('/ouvrage/composant/liste/{id}', name: 'app_affaire_ouvrage_liste_composant', methods: ['GET', 'POST'])]
    public function listeComposant(Ouvrage $ouvrage, Request $request, Environment $environment, ComposantRepository $composantRepository, OuvrageRepository $ouvrageRepository): Response
    {
        $response = new Response();
        $path = "affaire/bibliothequeDePrix/modal_liste_composant_ouvrage.html.twig";

        //dd($ouvrage->getComposants());
        $composants = $ouvrage->getComposants();
        //dd($composants);


        if (!empty($path)) {
        try {
            $html = $environment->render($path, ["composants" => $composants, 'ouvrage' => $ouvrage]);
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

    #[Route('/modal/ouvrage/liste/{id}/{ouvrage}', name: 'app_affaire_modal_ouvrage_liste', methods: ['GET', 'POST'])]
    public function modalOuvrageListe(Request $request, Environment $environment,EntityManagerInterface $entityManager, Devis $devis,Ouvrage $ouvrage): Response
    {
        $response = new Response();

        $path = "affaire/bibliothequeDePrix/modal_ouvrage_list.html.twig";
        
        
        $tps= 0;
        $params = [
            'typeOuvrages'=>$entityManager->getRepository(TypeOuvrage::class)->findAll(),
            'categorieOuvrages'=>$entityManager->getRepository(CategorieOuvrage::class)->findAll(),
            'attributOuvrages'=>$entityManager->getRepository(AttributOuvrage::class)->findAll(),
            'ouvrage'=>$ouvrage,
            'tableDePrix'=>$entityManager->getRepository(TableDePrix::class)->findAll(),
        ];

        if (!empty($path)) {
            try {
                $html = $environment->render($path,$params);
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
                $html = $environment->render($path, ["ouvrage" => $ouvrage,'unites'=>$this->unites]);
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
                $html = $environment->render($path, ["types" => $typeComposantRepository->findAll(), "composant" => $composant, 'unites'=>$this->unites]);
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
        $ouvrage->setPrixUnitaireDebourse(floatval($data['duht']));
        $ouvrage->setDenomination($data['denomination']);
        $unite = $this->uniteRepository->find($data['unite']);
        $ouvrage->setUnite($unite);
        $ouvrage->setMarge(1);
        $ouvrage->setCreateur($this->getUser());
        $ouvrage->setQuantite($data['quantite']);
        
        try {
            $ouvrageRepository->add($ouvrage);
            return new Response(json_encode(['code' => 200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
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
        key_exists('dtht', $data) ? $ouvrage->setDebourseHTCalcule($data['dtht']) : "";
        key_exists('duht', $data) ? $ouvrage->setPrixUnitaireDebourse($data['duht']) : "";
        key_exists('marge', $data) ? $ouvrage->setMarge($data['marge']) : "";
        key_exists('denomination', $data) ? $ouvrage->setDenomination($data['denomination']) : "";



        $unite = $this->uniteRepository->find($data['unite']);
        $ouvrage->setUnite($unite);
        $ouvrage->setQuantite($data['quantite']);


        //key_exists('note', $data) ? $ouvrage->setNote($data['note']) : $ouvrage->setNote(null);
        //key_exists('quantiteDOuvrage', $data) ? $ouvrage->setQuantite($data['quantiteDOuvrage']) : $ouvrage->setQuantite(null);
        try {
            $ouvrageRepository->add($ouvrage);
            $dataBottom = $this->calculService->recursiveCalculBottom(['id'=>$ouvrage->getId(),'type'=>'ouvrage']);
            $dataTop= $this->calculService->recursiveCalculTop(['id'=>$ouvrage->getId(),'type'=>'ouvrage']);
            $data = array_merge($dataBottom,$dataTop);
            $data[]=$ouvrage->__toArray();
            return new Response(json_encode(['code' => 200,'data'=>$data]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/composant/edit/{id}', name: 'app_affaire_composant_edit', methods: ['POST'])]
    public function editComposant(Request $request, Composant $composant, ComposantRepository $composantRepository,OuvrageRepository $ouvrageRepository): Response
    {

        

        $data = $request->request->all();
        $data = $data['composant'];

        $composant->setCode($data['code']);
        $composant->setDebourseUnitaireHT($data['duht']);
        $composant->setDenomination($data['denomination']);
        $unite = $this->uniteRepository->find($data['unite']);
        $composant->setQuantite($data['quantite']);
        $composant->setUnite($unite);
        $composant->setMarge(floatval($data['marge']));
        $composant->setPrixDeVenteHT($composant->getMarge() * $composant->getDebourseUnitaireHT() * $composant->getQuantite());
        $composant->setNote(empty($data['note']) ? $composant->getNote(): $data['note']);
        $data = [];
        try {
            $composantRepository->add($composant);
            if(!empty($composant->getOuvrage())){
              //  $composant->getOuvrage()->setPrixDeVenteHT($composant->getOuvrage()->getSommePrixDeVenteHTComposants());
               // $composant->getOuvrage()->setMarge($composant->getOuvrage()->getSommePrixDeVenteHTComposants() / $composant->getOuvrage()->getSommeDebourseTotalComposants());
               // $ouvrageRepository->add($composant->getOuvrage());
               // $data = ['ouvrage'=>$composant->getOuvrage()->__toArray()];
            }
            $data =  $this->calculService->recursiveCalculTop(['id'=>$composant->getId(),'type'=>'composant']);
            $data[] = $composant->__toArray();
            return new Response(json_encode(['code' => 200,'data'=>$data]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
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
        $composant->setDenomination($data['denomination']);
        $unite = $this->uniteRepository->find($data['unite']);
        $composant->setUnite($unite);
        $composant->setMarge(floatval($data['marge']));
        $composant->setPrixDeVenteHT($composant->getMarge() * $composant->getDebourseUnitaireHT());
        $composant->setQuantite($data['quantite']);
        $composant->setCreateur($this->getUser());

        if (key_exists('ouvrage', $data)) {
            $sum = 0;
            $ouvrage = $ouvrageRepository->find($data['ouvrage']);
            $composant->setOuvrage($ouvrage);
            foreach ($ouvrage->getComposants() as $val) {
                $sum += $val->getPrixDeVenteHT();
            }
            $ouvrage->setPrixUnitaireDebourse($sum);
            $ouvrageRepository->add($ouvrage);
        }
        try {
            $composantRepository->add($composant);
            return new Response(json_encode(['code' => 200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
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
            $sum += $composant->getPrixDeVenteHT();
        }
        $ouvrage->setPrixUnitaireDebourse($sum);

        //  return new Response(json_encode($data));


        try {
            $ouvrageRepository->add($ouvrage);
            return new Response(json_encode(['code' => 200]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
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
            'nav' => [],
            'unites'=>$this->unites,
        ]);

    }

    #[Route('/composant/{id}', name: 'app_affaire_composant_show', methods: ['GET'])]
    public function showComposant(Composant $composant, TypeComposantRepository $typeComposantRepository): Response
    {

        return $this->render('affaire/bibliothequeDePrix/edit_composant.html.twig', [
            'composant' => $composant,
            'types' => $typeComposantRepository->findAll(),
            'title' => 'Composant : ' . $composant->getDenomination(),
            'unites'=>$this->unites,
            'nav' => []
        ]);

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
        $clone->setDenomination($data['denomination']);
        $unite = $this->uniteRepository->find($data['unite']);
        $clone->setUnite($unite);
        $clone->setMarge(floatval($data['marge']));
        $clone->setPrixDeVenteHT($clone->getMarge() * $clone->getDebourseUnitaireHT() * $clone->getQuantite());
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


    #[Route('/ouvrage/dupliquer/{id}', name: 'app_affaire_ouvrage_dupliquer', methods: ['GET', 'POST'])]
    public function dupliquerOuvrage(Request $request, Ouvrage $ouvrage, OuvrageRepository $ouvrageRepository, EntityManagerInterface $entityManager, ComposantRepository $composantRepository): Response
    {


        $data = $request->request->all()['ouvrage'];

        $clone = $ouvrage;


        $clone->setCode($data['code']);
        $clone->setDebourseHTCalcule($data['DUHT']);
        $clone->setDenomination($data['denomination']);
        $unite = $this->uniteRepository->find($data['unite']);
        $clone->setUnite($unite);
        $clone->setCreateur($this->getUser());
        foreach ($ouvrage->getComposants() as $composant) {
            $entityManager->detach($clone);
            $clone->addComposant($composant);
            $composant->setOuvrage($ouvrage);

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
