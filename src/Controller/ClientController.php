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

        $queryBuilder = $this->societeRepository->getclients();
    
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'title' => 'Clients',
            'nav' => [],
            'pagination' =>$pagination
        ]);

    }
}
