<?php

namespace App\Controller\Interlocuteur;

use App\Entity\Demande;
use App\Entity\Ged\Fichier;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Form\Ged\FichierType;
use App\Form\Interlocuteur\InterlocuteurType;
use App\Repository\DemandeRepository;
use App\Repository\Ged\FichierRepository;
use App\Repository\Interlocuteur\InterlocuteurRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/interlocuteur/interlocuteur')]
class InterlocuteurController extends AbstractController
{
    #[Route('/', name: 'app_interlocuteur_interlocuteur_index', methods: ['GET'])]
    public function index(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAll(),
            'title' => 'Liste des interlocuteurs',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/soustraitants', name: 'app_interlocuteur_interlocuteur_index_sous_traitant', methods: ['GET'])]
    public function sousTraitant(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAllByRole('ROLE_SOUS_TRAITANT'),
            'title' => 'Liste des sous traitants',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/transporteurs', name: 'app_interlocuteur_interlocuteur_index_transporteur', methods: ['GET'])]
    public function transporteur(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAllByRole('ROLE_TRANSPORTEUR'),
            'title' => 'Liste des transporteurs',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/fournisseurs', name: 'app_interlocuteur_interlocuteur_index_fournisseur', methods: ['GET'])]
    public function fournisseur(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAllByRole('ROLE_FOURNISSEUR'),
            'title' => 'Liste des fournisseurs',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/client', name: 'app_interlocuteur_interlocuteur_index_client', methods: ['GET'])]
    public function client(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAllByRole('ROLE_CLIENT'),
            'title' => 'Liste des clients',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/partenaire', name: 'app_interlocuteur_interlocuteur_index_partenaire', methods: ['GET'])]
    public function partenaire(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAllByRole('ROLE_PARTENAIRE'),
            'title' => 'Liste des sous partenaire',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }


    #[Route('/new', name: 'app_interlocuteur_interlocuteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InterlocuteurRepository $interlocuteurRepository): Response
    {
        $interlocuteur = new Interlocuteur();
        $form = $this->createForm(InterlocuteurType::class, $interlocuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($interlocuteur->getType() == "personne") {
                $interlocuteur->setSociete(NULL);
            } elseif ($interlocuteur->getType() == "societe") {
                $interlocuteur->setPersonne(NULL);
            }
            try {
                $interlocuteurRepository->add($interlocuteur);
                return $this->redirectToRoute('app_interlocuteur_interlocuteur_show', ['id' => $interlocuteur->getId()], Response::HTTP_SEE_OTHER);
            } catch (OptimisticLockException $e) {
                dd($e);
            } catch (ORMException $e) {
                dd($e);
            }
        }

        return $this->renderForm('interlocuteur/interlocuteur/new.html.twig', [
            'interlocuteur' => $interlocuteur,
            'form' => $form,
            'title' => 'Liste des interlocuteurs',
            'nav' => [],

        ]);
    }

    #[Route('/{id}', name: 'app_interlocuteur_interlocuteur_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Interlocuteur $interlocuteur, FichierRepository $fichierRepository, SluggerInterface $slugger, DemandeRepository $demandeRepository): Response
    {
        $fichier = new Fichier();

        $demamndes = $demandeRepository->findAllDemande($interlocuteur->getId());

        //  dd($demamndes);

        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('fichier')->getData();

            if ($brochureFile) {
                $fichier->setCreateur($this->getUser());
                $fichier->setInterlocuteur($interlocuteur);

                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                try {

                    $brochureFile->move(
                        __DIR__ . "/../../../uploads/" . $fichier->getTypeFichier()->getTitre() . "/",
                        $newFilename
                    );
                    $fichier->setFichier($newFilename);

                } catch (FileException $e) {
                    $this->addFlash('danger', $e->getMessage());
                    // ... handle exception if something happens during file upload
                }
            }

            $fichierRepository->add($fichier);
        }

        return $this->render('interlocuteur/interlocuteur/show.html.twig', [
            'form' => $form->createView(),
            'interlocuteur' => $interlocuteur,
            'demandes' => $demamndes,
            'title' => !empty($interlocuteur->getSociete()) ? $interlocuteur->getSociete()->getRaisonSociale() : $interlocuteur->getPersonne()->getNom(),
            'nav' => [['app_interlocuteur_interlocuteur_edit', 'Modifier', $interlocuteur->getId()]],

        ]);
    }

    #[Route('/{id}/edit', name: 'app_interlocuteur_interlocuteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Interlocuteur $interlocuteur, InterlocuteurRepository $interlocuteurRepository): Response
    {
        $form = $this->createForm(InterlocuteurType::class, $interlocuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($interlocuteur->getType() == "personne") {
                $interlocuteur->setSociete(NULL);
            } elseif ($interlocuteur->getType() == "societe") {
                $interlocuteur->setPersonne(NULL);
            }

            $interlocuteurRepository->add($interlocuteur);
            return $this->redirectToRoute('app_interlocuteur_interlocuteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interlocuteur/interlocuteur/edit.html.twig', [
            'interlocuteur' => $interlocuteur,
            'form' => $form,
            'title' => 'Liste des interlocuteurs',
            'nav' => [],
        ]);
    }

    #[Route('/delete/{id}', name: 'app_interlocuteur_interlocuteur_delete', methods: ['POST', 'GET'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Request $request, Interlocuteur $interlocuteur, InterlocuteurRepository $interlocuteurRepository): Response
    {

        if ($this->isCsrfTokenValid('delete' . $interlocuteur->getId(), $request->request->get('_token'))) {
            try {
                $interlocuteurRepository->remove($interlocuteur);
            } catch (OptimisticLockException|ORMException|ForeignKeyConstraintViolationException $e) {
                $this->addFlash('danger', 'Vous ne pouvez pas supprimer cette fiche car des éléments y sont liés');
                return $this->redirectToRoute('app_interlocuteur_interlocuteur_show', ['id' => $interlocuteur->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->redirectToRoute('app_interlocuteur_interlocuteur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route ('/menu/interlocuteur/{value}/{id}', name: 'app_interlocuteur_interlocuteur_menu', methods: ['GET'])]
    public function activeMenu(Interlocuteur $interlocuteur, $value, InterlocuteurRepository $interlocuteurRepository): Response
    {
        $menu = $interlocuteur->getMenu();
        $menu[$this->getUser()->getId()] = $value;
        $interlocuteur->setMenu($menu);
        try {
            $interlocuteurRepository->add($interlocuteur);
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
