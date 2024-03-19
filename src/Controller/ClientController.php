<?php

namespace App\Controller;

use App\Entity\Interlocuteur\Societe;
use App\Repository\Interlocuteur\SocieteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    
    public function __construct(private SocieteRepository $societeRepository){
       
    }

    

    #[Route('/client', name: 'app_client')]
    public function index(Request $request,PaginatorInterface $paginator): Response
    {

        $clients = $this->societeRepository->getclients();
    
         
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'title' => 'Clients',
            'nav' => [],
            'clients' =>$clients
        ]);

    }
    #[Route('/show_information/{id}', name: 'show_client_chantiers')]
    public function show_informations_client(Societe $societe): Response
    {

    
         
        return $this->render('client/show_client.html.twig', [
            'controller_name' => 'ClientController',
            'title' => 'Clients',
            'nav' => [['app_client', 'Clients']],
            'societe' => $societe,

        ]);

    }
}
