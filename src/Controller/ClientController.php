<?php

namespace App\Controller;

use App\Repository\Interlocuteur\SocieteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    
    public function __construct(private SocieteRepository $societeRepository){
       
    }

    

    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'title' => 'Commandes',
            'nav' => []
        ]);

    }
}
