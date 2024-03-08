<?php

namespace App\Controller;

use App\Entity\Depot\Transports;
use App\Entity\Depot\Transporteur;
use App\Repository\Affaire\TransportRepository;
use App\Repository\Depot\TransporteurRepository;
use App\Repository\Transport\CdeMatEntRepository;
use App\Service\OutlookService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class TransportsController extends AbstractController
{
    
    public function __construct(
        private CdeMatEntRepository $cdeMatEntRepository,
        private TransporteurRepository $transporteurRepository,
        private TransportRepository $transportRepository,
        private OutlookService $outlookService,


    ) {
    }

    #[Route('/transports', name: 'app_transports')]
    public function index(): Response
    {
        $transports = $this->transportRepository->findAll();
        return $this->render('transports/index.html.twig', [
            'controller_name' => 'TransportsController',
            'title' => 'Transports',
            'transports' => $transports,
            'nav' => []
        ]);
    }

    #[Route('/affectation', name: 'app_affectation')]
    public function affectation_transport_commande(Request $request):JsonResponse {
        try {
            $transporteurId = $request->request->get('transporteur');
            $typeEnlevement = $request->request->get('type_enlevement');
            $heure = $request->request->get('heure');
            $taux = $request->request->get('taux');
            $tarification = $request->request->get('tarification');
            $cmdCodeEntre = $request->request->get('cmdCodeEntre');
            $observation = $request->request->get('observation');

            $transporteurObject = $this->transporteurRepository->findTransporteurById($transporteurId);
            $commandeEntObject = $this->cdeMatEntRepository->findCdeById($cmdCodeEntre);
    
            // Check if any of the required parameters are null, throw an exception if so
            if ($transporteurObject === null || $commandeEntObject === null) {
                return new JsonResponse(['message' => 'Transporteur or Commande object not found.'], JsonResponse::HTTP_CONFLICT);

            }
    
            $transpots = new Transports();
            $transpots->setIdtransporteur($transporteurObject);
            $transpots->setMontant($tarification);
            $transpots->setSens(1);
            $transpots->setNumchantierdep(1);
            $transpots->setHeuredep($heure);
            $transpots->setTypeEnlevement($typeEnlevement);
            $transpots->setTauxPrefere($taux);

            
            // Définir la date formatée dans votre objet Transports
            $transpots->setDatesaisie(new DateTime());
            $transpots->setIdcde($commandeEntObject);
            $transpots->setObservation($observation);
            $transpots->setNumchantierarr($commandeEntObject->getCodeChantier());
            $this->transportRepository->add($transpots);
            $this->outlookService->change_to_affreter($commandeEntObject->getIdCalendar());
            return new JsonResponse(['message' => 'La commande a bien été affectée.'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            // Log the exception or handle it according to your needs
            dd($e->getMessage());
            return new JsonResponse(['error' => 'An error occurred.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    
    }
}
