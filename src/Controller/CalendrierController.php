<?php

namespace App\Controller;

use App\Repository\Depot\TransporteurRepository;
use App\Service\OutlookService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendrierController extends AbstractController
{


    public function __construct(
        private OutlookService $outlookService,
        private TransporteurRepository $transporteurRepository
    ) {
    }

    #[Route('/calendrier', name: 'app_calendrier')]
    public function index(): Response
    {
        $transports = $this->transporteurRepository->findAll();
        return $this->render('calendrier/index.html.twig', [
            'controller_name' => 'CalendrierController',
            'title' => 'Mouvements',
            'transports' => $transports,
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

    #[Route('/event-save', name: 'app_event_date_save')]
    public function save_event(Request $request): Response
    {
        try {
            $startDate = $request->request->get('startDate');

            $endDate = $request->request->get('endDate');
            $subject = $request->request->get("subject");
            $location = $request->request->get('location');
            $attachmentFile = $request->files->get('attachment');


            $response = $this->outlookService->addEvents($subject, $startDate, $endDate, $location,$attachmentFile);
            return $this->json($response);
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }
}
