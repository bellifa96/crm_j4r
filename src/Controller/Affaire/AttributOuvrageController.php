<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\AttributOuvrage;
use App\Entity\Affaire\Ouvrage;
use App\Entity\Affaire\TypeOuvrage;
use App\Entity\Unite;
use App\Form\Affaire\AttributOuvrageType;
use App\Repository\Affaire\AttributOuvrageRepository;
use App\Repository\Affaire\AutreOuvrageRepository;
use App\Repository\Affaire\ComposantRepository;
use App\Repository\Affaire\MetreRepository;
use App\Repository\Affaire\OuvrageRepository;
use App\Repository\Affaire\TypeOuvrageRepository;
use App\Repository\UniteRepository;
use App\Service\CalculService;
use App\Service\PdfService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use function PHPUnit\Framework\isNan;

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
            'title' => 'attribut ouvrage',
            'nav' => []
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
            'title' => 'attribut ouvrage',
            'nav' => []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_attribut_ouvrage_show', methods: ['GET'])]
    public function show(AttributOuvrage $attributOuvrage): Response
    {
        return $this->render('affaire/attribut_ouvrage/show.html.twig', [
            'attribut_ouvrage' => $attributOuvrage,
            'title' => 'attribut ouvrage',
            'nav' => []
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
            'title' => 'attribut ouvrage',
            'nav' => []
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_attribut_ouvrage_delete', methods: ['POST'])]
    public function delete(Request $request, AttributOuvrage $attributOuvrage, AttributOuvrageRepository $attributOuvrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $attributOuvrage->getId(), $request->request->get('_token'))) {
            $attributOuvrageRepository->remove($attributOuvrage, true);
        }

        return $this->redirectToRoute('app_affaire_attribut_ouvrage_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/set/{id}', name: 'app_affaire_attribut_ouvrage_set', methods: ['POST'])]
    public function setOuvrageAttribut(Request $request, CalculService $calculService, Ouvrage $ouvrage, OuvrageRepository $ouvrageRepository, TypeOuvrageRepository $typeOuvrageRepository, ComposantRepository $composantRepository, UniteRepository $uniteRepository, MetreRepository $metreRepository, AutreOuvrageRepository $autreOuvrageRepository)
    {

        $data = $request->request->all();
        $data = $data["attribut"];

        $data['poidsDeReference'] = floatval($data['poidsDeReference']);
        $data['pourcentageTpsDeReference'] = floatval($data['pourcentageTpsDeReference']);
        $data['tpsDeReference'] = floatval($data['tpsDeReference']);
        $data['quantite2'] = intval($data['quantite2']);
        $data['largeur'] = floatval($data['largeur']);

        // dd($autreOuvrage);

        $ouvrage->setDenomination($data['denomination']);
        $ouvrage->setTypeOuvrage($typeOuvrageRepository->find($data['TypeOuvrage']));

        foreach ($data['metre'] as $key => $value) {
            $metre = $metreRepository->find($key);
            switch ($metre->getTypeMetre()) {
                case 'longueur':
                    $metre->setLongueur(!empty($value) ? floatval(str_replace(',', '.', $value)) : null);
                    break;
                case 'hauteur':
                    $metre->setHauteur(!empty($value) ? floatval(str_replace(',', '.', $value)) : null);
                    break;
                case 'lineaire':
                    $metre->setLineaire($value);
                    break;
                default:
                    break;
            }
            $metreRepository->save($metre);
        }
        $quantiteOuvrage = 0;
        if ($ouvrage->getTypeOuvrage()->getCode() === "A") {
            $autreOuvrage = $autreOuvrageRepository->find($data['autreOuvrage']);
            $autreOuvrage->addOuvrage($ouvrage);
            if ($autreOuvrage->getUnite() === "m2" || $autreOuvrage->getUnite() === "ml") {
                $ouvrage->setUnite($autreOuvrage->getUnite());
            } else {
                $ouvrage->setUnite($uniteRepository->findOneByLabel('unité'));
            }

            $ouvrage->setMarge($autreOuvrage->getMarge());
            if ($ouvrage->getUnite()->getLabel() === "ml") {
                foreach ($metreRepository->findAll() as $hauteur) {
                    if ($hauteur->getTypeMetre() === 'hauteur') {
                        if ($hauteur->getOuvrage()->getId() === $ouvrage->getId()) {
                            $quantiteOuvrage += $metreRepository->sommeLongueurs($hauteur);
                        }
                    }
                }
            } else if ($ouvrage->getUnite()->getLabel() === "m2"){
                foreach ($metreRepository->findAll() as $hauteur) {
                    if ($hauteur->getTypeMetre() === 'hauteur') {
                        if ($hauteur->getOuvrage()->getId() === $ouvrage->getId()) {
                            $quantiteOuvrage += $metreRepository->sommeLongueurs($hauteur) * $hauteur->getHauteur();
                        }
                    }
                }
            }
            else {
                $quantiteOuvrage = $data['quantiteAutreOuvrage'];
            }
        } else {

            $ouvrage->setPourcentageTpsDeReference($data['pourcentageTpsDeReference']);
            $ouvrage->setTpsDeReference($data['tpsDeReference']);
            $ouvrage->setPoidsDeReference($data['poidsDeReference']);
            $ouvrage->setAttributs($data['attributs']);
            if (in_array($ouvrage->getTypeOuvrage()->getCode(), ['E', 'PAR'])) {
                $ouvrage->setUnite($uniteRepository->findOneById(1));
            } else {
                $ouvrage->setUnite($uniteRepository->findOneById(9));
            }
            foreach ($metreRepository->findAll() as $hauteur) {
                if ($hauteur->getTypeMetre() === 'hauteur') {
                    if ($hauteur->getOuvrage()->getId() === $ouvrage->getId()) {
                        $quantiteOuvrage += $metreRepository->sommeLongueurs($hauteur) * $hauteur->getHauteur();
                    }
                }
            }
            if (!empty($data['largeur'])) {
                $ouvrage->setLargeur($data['largeur']);
                $quantiteOuvrage = $quantiteOuvrage * $data['largeur'];
            }
        }
        $ouvrage->setQuantite(round($quantiteOuvrage, 2));


        $responseData = [];
        foreach ($data['composants'] as $key => $val) {
            $val = str_replace(',', '.', $val);
            $val = floatval($val);
            $composant = $composantRepository->find($key);
            $composant->setDebourseUnitaireHT(round($val, 3));
            $composant->setUnite($ouvrage->getUnite());
            $composant->setMarge($ouvrage->getMarge());
            if (isset($data['composantsSelect'][$key]) && $data['composantsSelect'][$key] === 'on') {
                $composant->setQuantite(round($quantiteOuvrage, 2));
                $composant->setSelection(true);
            } else {
                $composant->setQuantite(0);
                $composant->setSelection(false);
            }

            if ($composant->getTypeComposant()->getCode() === 'L') {
                $composant->setQuantite2($data['quantite2']);
                $composant->setDebourseTotalHT(round($composant->getQuantite() * $val * $composant->getQuantite2(), 3));
            } elseif ($composant->getTypeComposant()->getCode() === 'ETU') {
                $composant->setQuantite(1);
                $composant->setDebourseTotalHT(round($composant->getQuantite() * $val, 3));
            } else {
                $composant->setDebourseTotalHT(round($composant->getQuantite() * $val, 3));
            }
            $composant->setPrixDeVenteHT(round($composant->getDebourseTotalHT() * $composant->getMarge(), 3));
            $composantRepository->add($composant);
            if ($key === array_key_last($data['composants'])) {
                $responseData = $calculService->recursiveCalculTop(['id' => $key, 'type' => 'composant']);
            }
        }

        // dd($data);

        $ouvrageRepository->add($ouvrage);

        foreach ($ouvrage->getComposants() as $composant) {
            $responseData[] = $composant->__toArray();
        }

        return new Response(json_encode(['code' => 200, 'data' => $responseData]));


    }

    #[Route('/edit/', name: 'app_affaire_attribut_table_edit', methods: ['POST'])]
    public function editTableAttribut(Request $request, AttributOuvrageRepository $attributOuvrageRepository): Response
    {
        $data = $request->request->all();
        // dd($data);

        foreach ($data['attributs'] as $updatedAttribut) {
            $attribut = $attributOuvrageRepository->find($updatedAttribut['id']);
            $attribut->setTitre($updatedAttribut['titre']);
            is_numeric($updatedAttribut['poids']) ? $attribut->setPoidsKG(floatval($updatedAttribut['poids'])) : $attribut->setPoidsKG(null);
            $attribut->setTps($updatedAttribut['temps']);

            // dd($updatedAttribut, $attribut);
            $attributOuvrageRepository->save($attribut);
        }

        return new Response(json_encode(['code' => 200]));
    }
}
