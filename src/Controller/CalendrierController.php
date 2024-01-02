<?php

namespace App\Controller;

use App\Service\OutlookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendrierController extends AbstractController
{  


    public function __construct(private OutlookService $outlookService) {
     
    }



    #[Route('/calendrier', name: 'app_calendrier')]
    public function index(): Response
    {
        return $this->render('calendrier/index.html.twig', [
            'controller_name' => 'CalendrierController',
        ]);
    }
}
