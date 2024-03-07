<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransportsController extends AbstractController
{
    #[Route('/transports', name: 'app_transports')]
    public function index(): Response
    {
        return $this->render('transports/index.html.twig', [
            'controller_name' => 'TransportsController',
        ]);
    }

    #[Route('/affectation', name: 'app_affectation')]
    public function affectation_transport_commande(Request $request){

    }
}
