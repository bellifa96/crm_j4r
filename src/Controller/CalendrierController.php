<?php

namespace App\Controller;

use App\Service\OutlookService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'title' => 'Mouvements',
            'nav' => []
        ]);
    }

    #[Route('/event-date', name: 'app_event_date')]
    public function getEventByDate(Request $request): Response
    {
        try {
            $date_du = $request->query->get('datedu');
            $date_au = $request->query->get('dateau');

            $response = $this->outlookService->getCalendarEvents($date_du, $date_au);

            

            return $this->json($response);
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }
}
