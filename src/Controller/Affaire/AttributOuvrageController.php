<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\AttributOuvrage;
use App\Entity\Affaire\Ouvrage;
use App\Entity\Affaire\TypeOuvrage;
use App\Form\Affaire\AttributOuvrageType;
use App\Repository\Affaire\AttributOuvrageRepository;
use App\Repository\Affaire\ComposantRepository;
use App\Repository\Affaire\OuvrageRepository;
use App\Repository\Affaire\TypeOuvrageRepository;
use App\Service\CalculService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/attribut/ouvrage')]
class AttributOuvrageController extends AbstractController
{
    #[Route('/', name: 'app_affaire_attribut_ouvrage_index', methods: ['GET'])]
    public function index(AttributOuvrageRepository $attributOuvrageRepository): Response
    {
      /*  $data= [
            ['poids'=>0,'tps'=>0,'titre'=>"sans console"],
            ['poids'=>3,'tps'=>0,'titre'=>"Console 28"],
            ['poids'=>5,'tps'=>0,'titre'=>"Console 39"],
            ['poids'=>10,'tps'=>0,'titre'=>"Console 73"],
            ['poids'=>15,'tps'=>0,'titre'=>"Console 109"],
        ];
        foreach($data as $val){
            $attribut = new AttributOuvrage();
            $attribut->setPoidsKG($val['poids']);
            $attribut->setTps($val['tps']);
            $attribut->setTitre($val['titre']);
            $attribut->setAttributOuvrage($attributOuvrageRepository->find(47));
            $attributOuvrageRepository->save($attribut,true);
        }*/
        return $this->render('affaire/attribut_ouvrage/index.html.twig', [
            'attribut_ouvrages' => $attributOuvrageRepository->findByIsTable(true),
            'title'=> 'attribut ouvrage',
            'nav'=> []
        ]);
    }

    #[Route('/new', name: 'app_affaire_attribut_ouvrage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AttributOuvrageRepository $attributOuvrageRepository): Response
    {
        $attributOuvrage = new AttributOuvrage();
        $form = $this->createForm(AttributOuvrageType::class, $attributOuvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributOuvrageRepository->save($attributOuvrage, true);

            return $this->redirectToRoute('app_affaire_attribut_ouvrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/attribut_ouvrage/new.html.twig', [
            'attribut_ouvrage' => $attributOuvrage,
            'form' => $form,
            'title'=> 'attribut ouvrage',
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_attribut_ouvrage_show', methods: ['GET'])]
    public function show(AttributOuvrage $attributOuvrage): Response
    {
        return $this->render('affaire/attribut_ouvrage/show.html.twig', [
            'attribut_ouvrage' => $attributOuvrage,
            'title'=> 'attribut ouvrage',
            'nav'=> []
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_attribut_ouvrage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AttributOuvrage $attributOuvrage, AttributOuvrageRepository $attributOuvrageRepository): Response
    {
        $form = $this->createForm(AttributOuvrageType::class, $attributOuvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributOuvrageRepository->save($attributOuvrage, true);

            return $this->redirectToRoute('app_affaire_attribut_ouvrage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/attribut_ouvrage/edit.html.twig', [
            'attribut_ouvrage' => $attributOuvrage,
            'form' => $form,
            'title'=> 'attribut ouvrage',
            'nav'=> []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_attribut_ouvrage_delete', methods: ['POST'])]
    public function delete(Request $request, AttributOuvrage $attributOuvrage, AttributOuvrageRepository $attributOuvrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attributOuvrage->getId(), $request->request->get('_token'))) {
            $attributOuvrageRepository->remove($attributOuvrage, true);
        }

        return $this->redirectToRoute('app_affaire_attribut_ouvrage_index', [], Response::HTTP_SEE_OTHER);
    }

    
    #[Route('/set/{id}', name: 'app_affaire_attribut_ouvrage_set', methods: ['POST'])]
    public function setOuvrageAttribut(Request $request,CalculService $calculService, Ouvrage $ouvrage,OuvrageRepository $ouvrageRepository,TypeOuvrageRepository $typeOuvrageRepository,ComposantRepository $composantRepository)
    {

        $data = $request->request->all();
        $data = $data["attribut"];
        dd($data);


        $ouvrage->setDenomination($data['denomination']);
        $ouvrage->setTpsDeReference($data['tpsDeReference']);
        $ouvrage->setPoidsDeReference($data['poidsDeReference']);
        $ouvrage->setAttributs($data['attributs']);
        $ouvrage->setTypeOuvrage($typeOuvrageRepository->find($data['TypeOuvrage']));
        $ouvrage->setPourcentageTpsDeReference($data['pourcentageTpsDeReference']);
        $responseData = [];

        foreach($data['composants'] as $key=>$val){
            $composant = $composantRepository->find($key);
            $composant->setDebourseUnitaireHT($val);
            $composantRepository->add($composant);
            if($key === array_key_last($data['composants'])){
                $responseData = $calculService->recursiveCalculTop(['id' => $key, 'type' => 'composant']);
            }
        }

       // dd($data);

        $ouvrageRepository->add($ouvrage);

        return new Response(json_encode(['code'=>200,'data'=>$responseData]));



    }
}
