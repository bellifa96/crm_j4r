<?php

namespace App\Controller;

use App\Entity\Depot\Etatsencours;
use App\Repository\Depot\EtatEnCoursRepository;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BonLayherController extends AbstractController
{

    public function __construct(
        private EtatEnCoursRepository $etatEncoursRepository,
    ) {
    }



    #[Route('/bon/layher', name: 'app_bon_layher')]
    public function index(): Response
    {
        $numaffaire = $this->etatEncoursRepository->getALLEtatEncoursbyactif();
        return $this->render('bon_layher/index.html.twig', [
            'controller_name' => 'BonLayherController',
            'title' => '',
            'affaires' => $numaffaire,
            'nav' => []
        ]);
    }

    #[Route('/get-bon-layher', name: 'app_bon_layher_get_entre_deux_date')]
    public function getBonLayherEntreDeuxDate(Request $request)
    {
        try {
            $date_du = $request->query->get('datedu');
            $date_au = $request->query->get('dateau');

            return $this->json([]);
        } catch (Exception $e) {

            return $this->json([]);
        }
    }
}
