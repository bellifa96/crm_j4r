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
    public function affectation_transport_commande(Request $request): JsonResponse
    {
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
            $this->outlookService->change_to_affreter($commandeEntObject->getIdCalendar(), $transporteurObject->getSociete());
            return new JsonResponse(['message' => 'La commande a bien été affectée.'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            // Log the exception or handle it according to your needs
            dd($e->getMessage());
            return new JsonResponse(['error' => 'An error occurred.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    #[Route('/edit-transport-liv/{id}', name: 'edit_transport_liv')]
    public function edit_transport(Transports $transports): Response
    {

        $transporteurs = $this->transporteurRepository->findAll();

        return $this->render('transports/form.html.twig', [
            'controller_name' => 'TransportsController',
            'title' => 'Transports',
            'transport' => $transports,
            'transporteurs' => $transporteurs,
            'nav' => []
        ]);
    }

    #[Route('/affectation-modifier', name: 'app_affectation_modifier')]
    public function affectation_transport_commande_modifier(Request $request): JsonResponse
    {
        try {
            $transporteurId = $request->request->get('transporteur');
            $typeEnlevement = $request->request->get('type_enlevement');
            $heure = $request->request->get('heure');
            $taux = $request->request->get('taux');
            $tarification = $request->request->get('tarification');
            $cmdCodeEntre = $request->request->get('cmdCodeEntre');
            $observation = $request->request->get('observation');
            $idtransport = $request->request->get('idtransport');

            $transporteurObject = $this->transporteurRepository->findTransporteurById($transporteurId);
            $commandeEntObject = $this->cdeMatEntRepository->findCdeById($cmdCodeEntre);

            // Check if any of the required parameters are null, throw an exception if so
            if ($transporteurObject === null || $commandeEntObject === null) {
                return new JsonResponse(['message' => 'Transporteur or Commande object not found.'], JsonResponse::HTTP_CONFLICT);
            }

            $transpots = $this->transportRepository->getById($idtransport);
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
            // $this->outlookService->change_to_affreter($commandeEntObject->getIdCalendar(),$transporteurObject->getSociete());
            return new JsonResponse(['message' => 'affectation a bien été affectée.'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            // Log the exception or handle it according to your needs
            dd($e->getMessage());
            return new JsonResponse(['error' => 'An error occurred.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    #[Route('/test', name: 'edit_transport_liv_test')]
    public function test(): Response
    {
        $texte = "LIV - J4R DEPOT - Lagny sur marne -No : 889815663-KARL";

        // Divise la chaîne en utilisant le délimiteur "-"
        $parties = explode("-", $texte);

        // Récupère le dernier élément du tableau
        $numero = trim(end($parties));

        // Vérifie si le numéro contient "No"
        if (strpos($numero, "No") !== false) { // Utilisez "!== false" pour une comparaison stricte
            $parties[] = "ESG";
        } else {
            $parties[count($parties) - 1] = "Quanka";

             // Ajoutez "ESG" au tableau des parties
        }

        // Rejoint les parties en utilisant le délimiteur "-"
        $texte_reconstruit = implode("-", $parties);

        echo $texte_reconstruit;



        // Vérifie si le tableau a au moins 4 parties


        dd("s");
        $transporteurs = $this->transporteurRepository->findAll();

        return $this->render('transports/form.html.twig', [
            'controller_name' => 'TransportsController',
            'title' => 'Transports',
            'transporteurs' => $transporteurs,
            'nav' => []
        ]);
    }
}
