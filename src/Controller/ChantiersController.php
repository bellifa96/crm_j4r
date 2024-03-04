<?php

namespace App\Controller;

use App\Repository\Depot\AgenceRepository;
use App\Repository\Depot\ChantiersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/chantier')]
class ChantiersController extends AbstractController
{  

    public function __construct(
      private ChantiersRepository $chantiersRepository
      ,private AgenceRepository $agenceRepository
    ) {
    }


    #[Route('/', name: 'app_chantiers')]
    public function index(): Response
    { 
        $chantiers = $this->chantiersRepository->getAllChantiers();
        $agences = $this->agenceRepository->findAll();

        return $this->render('chantiers/index.html.twig', [
            'controller_name' => 'CommandeController',
            'title' => 'Chantiers',
            'agences' => $agences,
            'chantiers' => $chantiers,
            'nav' => []
        ]);
    }
}
