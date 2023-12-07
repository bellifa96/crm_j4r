<?php

namespace App\Controller;

use App\Repository\Depot\AgenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
   private $agenceRepository;

   public function __construct(AgenceRepository $agenceRepository) {
    $this->agenceRepository = $agenceRepository;
   }


    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {

        $agences = $this->agenceRepository->findAll();
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            'title' => '',
            'agences' => $agences,
            'nav' => []

        ]);
    }
}
