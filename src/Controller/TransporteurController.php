<?php

namespace App\Controller;

use App\Repository\Depot\TransporteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransporteurController extends AbstractController
{

    public function __construct(private TransporteurRepository $transporteurRepository)
    {
    }

    #[Route('/transporteur', name: 'app_transporteur')]
    public function index(): Response
    {
        $transport = $this->transporteurRepository->findAll();
        return $this->render('transporteur/index.html.twig', [
            'controller_name' => 'TransporteurController',
            'transporteurs' => $transport,
            'title' => '',
            'nav' => []
        ]);
    }
}
