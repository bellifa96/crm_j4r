<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use App\Repository\DemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[Route('/demande')]
class DemandeController extends AbstractController
{
    #[Route('/', name: 'app_demande_index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository): Response
    {
        return $this->render('demande/index.html.twig', [
            'demandes' => $demandeRepository->findAll(),
            'title'=>'Liste des demandes',
            'nav'=>[['app_demande_new','ajouter une demande']]
        ]);
    }

    #[Route('/new', name: 'app_demande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DemandeRepository $demandeRepository): Response
    {
        $demande = new Demande();
        $demande->setCreateur($this->getUser());
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $data = $request->request->all()['demande'];

       //     dd($data);
            $demande->setTypeDePrestation($data['typeDePrestation']);
            $demande->setDocumentsSouhaites($data['documentsSouhaites']);
            $demande->setFondsDePlan($data['fondsDePlan']);


            if($demande->getTypeEchafaudage() == "Façade"){
                $demande->setTravauxPrevus($data['travauxPrevus']);
                $demande->setClasseDEchaffaudage($data['classeDEchaffaudage']);
                $demande->setTypeDeMateriel($data['typeDeMateriel']);
                $demande->setDimensions($data['dimensionsGlobales']);
                $demande->setAmmarages($data['ammarages']);
                $demande->setLargeurDeTravail($data['largeurDeTravail']);
                $demande->setConsoles($data['consoles']);
                $demande->setDistanceALaFacade($data['distanceALaFacade']);
                key_exists('rapportDistanceALaFacade',$data) ? $demande->setRapportDistanceALaFacade($data['rapportDistanceALaFacade']) :"";
                $demande->setHauteurDesPlanchers($data['hauteurDesPlanchers']);
                $demande->setEquipements($data['equipements']);
                key_exists('protectionCouvreur',$data)? $demande->setProtectionCouvreur($data['protectionCouvreur']) :"";
                key_exists('largeurPassagePieton',$data) ? $demande->setLargeurPassagePieton($data['largeurPassagePieton']) :"";
                $demande->setAcces($data['acces']);
                $demande->setBacheEtFilet($data['bacheEtFilet']);
                key_exists('bache',$data) ? $demande->setBache($data['bache']): "";
                $demande->setDimensionsGlobales($data['dimensionsGlobales']);
            }


        //   dd($data['typeDePrestation']);


           // $demande->setDocumentsSouhaites($form->getData()['typeDePrestation']);

            $demandeRepository->add($demande);
            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande/new.html.twig', [
            'demande' => $demande,
            'form' => $form,
            'title'=>'Créer une nouvelle Demande',
            'nav'=>[]
        ]);
    }

    #[Route('/{id}', name: 'app_demande_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
            'title'=> "Demande N° ".$demande->getId(),
            'nav'=> [['app_affaire_devis_new','Transformer en devis',$demande->getId()]]
        ]);
    }

    #[Route('/form/template', name: 'app_demande_form', methods: ['GET','POST'])]
    public function getForm(Request $request,Environment $environment): Response
    {

        $response = new Response();

        if($request->request->get('data') == "Façade"){
            $path = "demande/echafaudage/facade.html.twig";
        }elseif($request->request->get('data') == "Parapluie"){
            $path = "demande/echafaudage/parapluie.html.twig";

        }elseif($request->request->get('data') == "Particulier"){
            $path = "demande/echafaudage/particulier.html.twig";

        }elseif($request->request->get('data') == "Plateforme"){
            $path = "demande/echafaudage/plateforme.html.twig";
        }

        if(!empty($path)) {

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


    #[Route('/{id}/edit', name: 'app_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande, DemandeRepository $demandeRepository): Response
    {

        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($request->request,$form->getData());

            $demandeRepository->add($demande);
            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form,
            'title'=>'Liste des demandes',
            'nav'=>[['app_demande_new','ajouter une demande']]
        ]);
    }

    #[Route('/{id}', name: 'app_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, DemandeRepository $demandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->request->get('_token'))) {
            $demandeRepository->remove($demande);
        }

        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}
