<?php

namespace App\Controller;

use App\Entity\Depot\Chantiers;
use App\Form\ChantierType;
use App\Repository\Depot\AgenceRepository;
use App\Repository\Depot\ChantiersRepository;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

#[Route('/chantier')]
class ChantiersController extends AbstractController
{

    public function __construct(
        private ChantiersRepository $chantiersRepository,
        private AgenceRepository $agenceRepository,
        private LoggerInterface $logger,
        private UserRepository $userRepository
    ) {
    }


    #[Route('/', name: 'app_chantiers')]
    public function index(): Response
    {
        $this->logger->info('List Chantiers');
        $chantiers = $this->chantiersRepository->getAllChantiers();
        $agences = $this->agenceRepository->findAll();

        return $this->render('chantiers/index.html.twig', [
            'controller_name' => 'CommandeController',
            'title' => 'Chantiers',
            'agences' => $agences,
            'chantiers' => $chantiers,
            'nav' => [['add_chantiers', 'Ajouter Chantier']]
        ]);
    }
    // modifier chantiers
    #[Route('/edit-chantier/{id}', name: 'edit_chantiers')]
    public function edit_chantier(Chantiers $chantier, Request $request): Response
    {



        $form = $this->createForm(ChantierType::class, $chantier);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $resulat = $this->chantiersRepository->add_update_depot($chantier);
            if ($resulat) {
                $this->addFlash("success", "Dépot a été correctement modifier");
                return $this->redirectToRoute("app_chantiers");
            } else {
            }
        }

        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('chantiers/new.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Chantiers',
            'nav' => [['app_chantiers', 'Chantiers']]
        ]);
    }
 
    // add chantiers 
    #[Route('/add', name: 'add_chantiers')]
    public function add_chantiers(Request $request): Response
    {


        $chantier = new Chantiers();
        $form = $this->createForm(ChantierType::class, $chantier);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            $resulat = $this->chantiersRepository->add_update_depot($chantier);
            if ($resulat) {
                $this->addFlash("success", "Dépot a été correctement modifier");
                return $this->redirectToRoute("app_chantiers");
            } else {
            }
        }

        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('chantiers/new.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Chantier',
            'nav' => [['app_chantiers', 'Chantiers']]
        ]);
    }
    #[Route('/get-chantier-adresse', name: 'get_chantiers_address')]
    public function chantier_par_id_address(Request $request)
    {
        try {
            $chantier = $request->query->get('chantier');
            $chantiers = $this->chantiersRepository->findById($chantier);


            return $this->json($chantiers);
        } catch (Exception $e) {

            return $this->json([]);
        }
    }

    #[Route('/affectation-chantiers', name: 'affectation_chantier')]
    public function affectation_chantiers(Request $request)
    {
        $this->logger->info('List Chantiers');
        $chantiers = $this->chantiersRepository->getAllChantiersEncours();

        $agences = $this->agenceRepository->findAll();
        $conducteur_travaux = $this->userRepository->getEmailsForRoleConducteurTraveaux()->getResult();
        return $this->render('chantiers/affectation.html.twig', [
            'controller_name' => 'CommandeController',
            'title' => 'Chantiers',
            'agences' => $agences,
            'chantiers' => $chantiers,
            'conducteur' =>$conducteur_travaux,
            'nav' => []
        ]);
    }
}
