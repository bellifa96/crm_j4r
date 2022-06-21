<?php

namespace App\Controller;

use App\Entity\Affaire\Evenement;
use App\Repository\Affaire\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use thiagoalessio\TesseractOCR\TesseractOCR;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'title' => 'Dashboard',
            'nav' => [],
        ]);
    }

    #[Route('/calendar', name: 'app_calendar')]
    public function calendar(EvenementRepository $evenementRepository):Response
    {
        $evenements = $evenementRepository->findAll();
        $calendar = [];
        $colors = [
            'Urgent' => 'red',
            'Important' => 'orange',
            'Normal' => 'green',
            'Faible' => 'grey'
        ];
        foreach ($evenements as $evenement) {
            $calendar[] = [
                'id' => $evenement->getId(),
                'start' => $evenement->getDateDeDebut()->format('Y-m-d H:i:s'),
                'end' => $evenement->getDateDeFin()->format('Y-m-d H:i:s'),
                'title' => $evenement->getTitre(),
                'description' => $evenement->getDescription(),
                'backgroundColor' => $colors[$evenement->getPriorite()],
                'borderColor' => $colors[$evenement->getPriorite()],
                'allDay' => false,
                'url' => '',
            ];
        }
        return new Response(json_encode($calendar));
    }

    #[Route('/calendar/evenement/update/{id}', name: 'app_calendar_update')]
    public function calendarUpdate(Evenement $evenement,Request $request):Response
    {
        $data = json_decode($request->getContent());

        dd($data);

        $evenement->setDateDeDebut();
        $evenement->setDateDeFin();

    }

}
