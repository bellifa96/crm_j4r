<?php

namespace App\Controller;

use App\Entity\Depot\Mouvements;
use App\Service\MouvementsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MouvementsController extends AbstractController
{

    public function __construct(private MouvementsService $mouvementsService)
    {
    }

    #[Route('/MOUY', name: 'app_mouvements')]
    public function index(): Response
    {
        return $this->render('mouvements/index.html.twig', [
            'controller_name' => 'MouvementsController',
        ]);
    }

    #[Route('/mouvements', name: 'app_mouvements')]
    public function add_Mouvement(Request $request): Response
    {
        $jsonData = $request->getContent();

        $data = json_decode($jsonData, true);
        $code =  -1;
        switch ($data["typeRegul"]) {
            case 1:
                $code = $this->mouvementsService->regulPlusDepot($data);
                break;
                // Add more cases as needed
            case 2:
                $code = $this->mouvementsService->regulMoinsDepot($data);
                break;
            case 3:
                $code = $this->mouvementsService->pertes_chantier($data);
                break;
            case 5:
                $code = $this->mouvementsService->vol_chantier($data);
                break;
            case 7:
                $code = $this->mouvementsService->materiel_HS_chantier($data);
                break;
            case 9:
                $code = $this->mouvementsService->gains_chantier($data);
                break;
            case 10:
                $code = $this->mouvementsService->gains_depot($data);
                break;
            case 4:
                $code = $this->mouvementsService->perte_stock($data);
                break;
            case 6:
                $code = $this->mouvementsService->vol_depot($data);
                break;
            case 8:
                $code = $this->mouvementsService->materail_hs_depot($data);
                break;
            
        }

        return $this->json($code);
    }
}
