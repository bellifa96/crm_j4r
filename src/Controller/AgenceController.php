<?php

namespace App\Controller;

use App\Repository\Depot\AgenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgenceController extends AbstractController
{

    private $agenceRepository;


    public function __construct(AgenceRepository $agenceRepository)
    {
        $this->agenceRepository = $agenceRepository;
  
    }



    #[Route('/agence', name: 'app_agence')]
    public function index(): Response
    {  

        $agences = $this->agenceRepository->findAll();
        return $this->render('agence/index.html.twig', [
            'controller_name' => 'AgenceController',
            'title' => '',
            'agences' => $agences,
            'nav' => []
        ]);

          
    }
}
