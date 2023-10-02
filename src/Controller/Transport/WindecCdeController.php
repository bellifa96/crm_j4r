<?php

namespace App\Controller\Transport;

use App\Form\Transport\WindecCdeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transport/windeccde')]
class WindecCdeController extends AbstractController
{
    #[Route('/', name: 'app_transport_windeccde_index', methods: ['GET', 'POST'])]
    public function index(Request $request)
    {
        $form = $this->createForm(WindecCdeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitez les données du formulaire ici
            $data = $form->getData();
            $commande = $data['NumCommande'];

            // Faites ce que vous voulez avec les données
            $json = file_get_contents("https://cloud.layher.fr/get/".strval($commande));
            $data2 = json_decode($json);
            echo 'la commande à été créée.';
        }

        return $this->render('transport/windecde/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }    
}