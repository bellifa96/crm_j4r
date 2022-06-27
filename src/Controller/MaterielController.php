<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Ged\Fichier;
use App\Entity\Materiel;
use App\Form\Ged\FichierType;
use App\Form\MaterielType;
use App\Repository\DemandeRepository;
use App\Repository\Ged\FichierRepository;
use App\Repository\MaterielRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/materiel')]
class MaterielController extends AbstractController
{
    #[Route('/', name: 'app_materiel_index', methods: ['GET'])]
    public function index(MaterielRepository $materielRepository): Response
    {
        return $this->render('materiel/index.html.twig', [
            'materiels' => $materielRepository->findAll(),
            'title' => "Inventaire",
            'nav' => [['app_materiel_new', 'Matériel +']],
        ]);
    }

    #[Route('/new', name: 'app_materiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MaterielRepository $materielRepository, SluggerInterface $slugger): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('photo')->getData();

            if ($brochureFile) {

                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                try {

                    $brochureFile->move(
                        __DIR__ . "/../../public/uploads/materiel/",
                        $newFilename
                    );
                    $materiel->setPhoto($newFilename);

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            $materielRepository->add($materiel, true);

            return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiel/new.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
            'title' => "Ajouter un matériel",
            'nav' => [],
        ]);
    }

    #[Route('/{id}', name: 'app_materiel_show', methods: ['GET', 'POST'])]
    public function show(Materiel $materiel, Request $request, FichierRepository $fichierRepository, SluggerInterface $slugger): Response
    {
        $fichier = new Fichier();

        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('fichier')->getData();

            if ($brochureFile) {
                $fichier->setMateriel($materiel);
                $fichier->setCreateur($this->getUser());

                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                try {

                    $brochureFile->move(
                        __DIR__ . "/../../uploads/" . $fichier->getTypeFichier()->getTitre() . "/",
                        $newFilename
                    );

                    $fichier->setFichier($newFilename);
                    $fichierRepository->add($fichier);

                } catch (FileException $e) {
                    $this->addFlash('danger', $e->getMessage());
                    // ... handle exception if something happens during file upload
                }
            }


            return $this->redirectToRoute('app_materiel_show', ['id' => $materiel->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('materiel/show.html.twig', [
            'form' => $form->createView(),
            'materiel' => $materiel,
            'title' => $materiel->getTitre(),
            'nav' => [],
        ]);
    }

    #[Route('/{id}/edit', name: 'app_materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Materiel $materiel, MaterielRepository $materielRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $brochureFile = $form->get('photo')->getData();

            if ($brochureFile) {

                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                try {

                    $brochureFile->move(
                        __DIR__ . "/../../public/uploads/materiel/",
                        $newFilename
                    );
                    $materiel->setPhoto($newFilename);

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            $materielRepository->add($materiel, true);

            return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiel/edit.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
            'title' => "modifier le matériel N°" . $materiel->getId(),
            'nav' => [],
        ]);
    }

    #[Route('/{id}', name: 'app_materiel_delete', methods: ['POST'])]
    public function delete(Request $request, Materiel $materiel, MaterielRepository $materielRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $materiel->getId(), $request->request->get('_token'))) {
            $materielRepository->remove($materiel, true);
        }

        return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route ('/menu/materiel/{value}/{id}', name: 'app_materiel_menu', methods: ['GET'])]
    public function activeMenu(Materiel $materiel, $value, MaterielRepository $materielRepository) :Response
    {
        $menu = $materiel->getMenu();
        $menu[$this->getUser()->getId()] = $value;
        $materiel->setMenu($menu);
        try {
            $materielRepository->add($materiel);
            return new Response(json_encode([
                'code' => 200,
                'message' => 'Ok'
            ]));
        } catch (OptimisticLockException|ORMException $e) {
            dd($e);
        }

        return new Response(json_encode([
            'code' => 404,
            'message' => 'Erreur'
        ]));

    }
}
