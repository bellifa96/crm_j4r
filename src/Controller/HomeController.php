<?php

namespace App\Controller;

use App\Entity\Affaire\Evenement;
use App\Repository\Affaire\EvenementRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
            if($this->getUser() != $evenement->getCreateur() and !$evenement->getAttribueA()->contains($this->getUser()) and !$this->isGranted("ROLE_ADMIN")) {
               continue;
            }
            $url = "";
            $title = "";
            if(!empty($evenement->getDemande())){
                $url = "/demande/".$evenement->getDemande()->getId();
                $title = "Demande : ";
            }
            $calendar[] = [
                'id' => $evenement->getId(),
                'start' => $evenement->getDateDeFin()->format('Y-m-d H:i:s'),
                'end' => $evenement->getDateDeFin()->format('Y-m-d H:i:s'),
                'title' => $title.$evenement->getTitre(),
                'description' => $evenement->getDescription(),
                'backgroundColor' => "white",
                'borderColor' => $colors[$evenement->getPriorite()],
                'textColor' => $colors[$evenement->getPriorite()],
                'allDay' => false,
                'hasEnd'=>true,
                'url' => $url,
            ];
        }
        return new Response(json_encode($calendar));
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/calendar/evenement/update/{id}', name: 'app_calendar_update')]
    public function calendarUpdate(Evenement $evenement,Request $request,EvenementRepository $evenementRepository):Response
    {
        $data = json_decode($request->getContent());


        $evenement->setDateDeDebut(new \DateTime($data->start));
        $evenement->setDateDeFin(new \DateTime($data->end));
        try {
            $evenementRepository->add($evenement);
            return new Response(json_encode(['code'=>200,'message'=>'ok']));

        } catch (OptimisticLockException $e) {
            return new Response(json_encode($e->getMessage()));
        } catch (ORMException $e) {
            return new Response(json_encode($e->getMessage()));
        }


    }

}
