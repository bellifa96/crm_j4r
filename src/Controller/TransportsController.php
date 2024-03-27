<?php

namespace App\Controller;

use App\Entity\Depot\Transports;
use App\Entity\Depot\Transporteur;
use App\Repository\Affaire\TransportRepository;
use App\Repository\Depot\ChantiersRepository;
use App\Repository\Depot\TransporteurRepository;
use App\Repository\Transport\CdeMatEntRepository;
use App\Repository\UserRepository;
use App\Service\OutlookService;
use Doctrine\ORM\EntityManagerInterface;
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
        private ChantiersRepository $chantiersRepository,
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManagerInterface

    ) {
    }

    #[Route('/transports', name: 'app_transports')]
    public function index(): Response
    {
        $transports = $this->transportRepository->getTransportAffecter(0);
        return $this->render('transports/index.html.twig', [
            'controller_name' => 'TransportsController',
            'title' => 'Transports',
            'transports' => $transports,
            'nav' => [['edit_transport_liv_new', 'Création un Transport']]
        ]);
    }

    #[Route('/transports_creer', name: 'app_transports_creer')]
    public function transports_creer(): Response
    {
        $transports = $this->transportRepository->getTransportAffecter(1);
        return $this->render('transports/transport_creer.html.twig', [
            'controller_name' => 'TransportsController',
            'title' => 'Transports',
            'transports' => $transports,
            'nav' => [['edit_transport_liv_new', 'Création un Transport']]
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
            $date_livraison = $request->request->get('date_livraison');

            $transporteurObject = $this->transporteurRepository->findTransporteurById($transporteurId);
            $commandeEntObject = $this->cdeMatEntRepository->findCdeById($cmdCodeEntre);

            // Check if any of the required parameters are null, throw an exception if so
            if ($transporteurObject === null || $commandeEntObject === null) {
                return new JsonResponse(['message' => 'Transporteur or Commande object not found.'], JsonResponse::HTTP_CONFLICT);
            }
            $transpots = new Transports();

            if($typeEnlevement != ""){
                $transpots->setTypeEnlevement($typeEnlevement);

            }
            $chantiersDepart  = $this->chantiersRepository->findByIdNumChantier(1);

            $transpots->setIdtransporteur($transporteurObject);
            $transpots->setMontant($tarification);
            $transpots->setTypeTransport(1);
             $transpots->setNumchantierdep($chantiersDepart);
            $transpots->setHeuredepart($heure);
            $transpots->setTauxPrefere($taux);
            $transpots->setDateLivraison($date_livraison);


            // Définir la date formatée dans votre objet Transports
            $transpots->setDatesaisie(new DateTime());
            $transpots->setIdcde($commandeEntObject);
            $transpots->setObservation($observation);

            $transpots->setNumchantierarr($commandeEntObject->getChantier());
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
        $chantiers_by_agence = $this->chantiersRepository->getAllChantiersEncours();

        return $this->render('transports/form.html.twig', [
            'controller_name' => 'TransportsController',
            'title' => 'Transports',
            'transport' => $transports,
            'transporteurs' => $transporteurs,
            'chantiers'=>$chantiers_by_agence,
            'cdeEnteHeure' => "",
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
            $date_livraison = $request->request->get('date_livraison');
            $dateLivraisonObject = new DateTime($date_livraison);

            $transporteurObject = $this->transporteurRepository->findTransporteurById($transporteurId);
            $commandeEntObject = $this->cdeMatEntRepository->findCdeById($cmdCodeEntre);

            // Check if any of the required parameters are null, throw an exception if so
            if ($transporteurObject === null || $commandeEntObject === null) {
                return new JsonResponse(['message' => 'Transporteur or Commande object not found.'], JsonResponse::HTTP_CONFLICT);
            }

            $transpots = $this->transportRepository->getById($idtransport);
            $transpots->setIdtransporteur($transporteurObject);
            $transpots->setMontant($tarification);
            $transpots->setTypeTransport(1);
            $transpots->setHeuredepart($heure);
            $transpots->setTypeEnlevement($typeEnlevement);
            $transpots->setTauxPrefere($taux);
            $transpots->setDateLivraison($dateLivraisonObject);


            // Définir la date formatée dans votre objet Transports
            $transpots->setObservation($observation);
            $this->transportRepository->add($transpots);
            $this->outlookService->change_to_affreter($commandeEntObject->getIdCalendar(),$transporteurObject->getSociete());
            return new JsonResponse(['message' => 'affectation a bien été affectée.'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            // Log the exception or handle it according to your needs
            dd($e->getMessage());
            return new JsonResponse(['error' => 'An error occurred.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/affectation-modifier-new', name: 'app_affectation_modifier_new')]
    public function affectation_transport_commande_modifier_new(Request $request): JsonResponse
    {
        try {

            $transporteurId = $request->request->get('transporteur');
            $typeEnlevement = $request->request->get('type_enlevement');
            $heure = $request->request->get('heure');
            $taux = $request->request->get('taux');
            $tarification = $request->request->get('tarification');
            $observation = $request->request->get('observation');
            $idtransport = $request->request->get('idtransport');

            $sens = $request->request->get('sens');
            $poids = $request->request->get('poids');

            $address_chantier = $request->request->get('address_chantier');
            $indication = $request->request->get('indication');
            $commande_chantier = $request->request->get('commande_chantier');
            $chantiersDepartarrive  =$request->request->get('commande_chantier_arrive');
            $date_transport = $request->request->get('date_transport');
            $date_transport = DateTime::createFromFormat('Y-m-d', $date_transport);
            $heure_dep1_transport  = $request->request->get('heure_dep1_transport');
            $heureprev  = $request->request->get('heureprev');


            $transporteurObject = $this->transporteurRepository->findTransporteurById($transporteurId);

            // Check if any of the required parameters are null, throw an exception if so
            if ($transporteurObject === null) {
                return new JsonResponse(['message' => 'Transporteur or Commande object not found.'], JsonResponse::HTTP_CONFLICT);
            }

            $chantiersDepart  = $this->chantiersRepository->findByIdChantier($commande_chantier);
            $chantiersArriveTransfert = $this->chantiersRepository->findByIdChantier($chantiersDepartarrive);
            $chantierslagny= $this->chantiersRepository->findByIdNumChantier(1);

            $transpots = $this->transportRepository->getById($idtransport);
            $transpots->setIdtransporteur($transporteurObject);
            $transpots->setMontant($tarification);
            $transpots->setTypeTransport(1);
            $transpots->setHeuredepart($heure);
            $transpots->setTypeEnlevement($typeEnlevement);
            $transpots->setTauxPrefere($taux);
            $transpots->setTypeTransport($sens);

            $transpots->setAdressechantier($address_chantier);
            $transpots->setPoidsbon($poids);
            $transpots->setVolume($indication);

            $transpots->setHeuredepart($heure);
            $transpots->setTauxPrefere($taux);
            $transpots->setcreationAffectation(1);
            $transpots->setDateTransport($date_transport);
 


            switch ($sens) {
                case 1:
                    // Ce cas représente une option de Livraison
                    $transpots->setHeuredepart($heure_dep1_transport);
                    $transpots->setHeuredep2($heure);

                    $transpots->setNumchantierdep($chantierslagny);
                    $transpots->setNumchantierarr($chantiersDepart);

                    break;
                case 2:
                    // Ce cas représente une option de Ramasse TY
                    $transpots->setHeuredepart($heure_dep1_transport);
                    $transpots->setHeuredep2($heure);

                    $transpots->setNumchantierdep($chantiersDepart);
                    $transpots->setNumchantierarr($chantierslagny);

                    break;
                case 3:
                    // Ce cas représente une option de Ramasse TS
                    $transpots->setHeuredepart($heure_dep1_transport);
                    $transpots->setHeuredep2($heure);

                    $transpots->setNumchantierdep($chantiersDepart);
                    $transpots->setNumchantierarr($chantierslagny);

                    break;
                case 4:
                    // Ce cas représente une option de Rotation
                    $transpots->setHeuredepart($heure_dep1_transport);
                    $transpots->setHeuredep2($heure);
                    $transpots->setNbheuresprev($heureprev);

                    $transpots->setNumchantierdep($chantiersDepart);
                    $transpots->setNumchantierarr($chantiersDepart);

                    break;
                case 5:
                    // Ce cas représente une option de Transfert
                    $transpots->setHeuredepart($heure_dep1_transport);
                    $transpots->setHeuredep2($heure);

                    $transpots->setNumchantierdep($chantiersDepart);
                    $transpots->setNumchantierarr($chantiersArriveTransfert);

                    break;
                default:
                    // C'est l'option par défaut si aucune des précédentes ne correspond
              
                    break;
                }


            $event_id = $this->outlookService->modifierEvenetTransport($transpots);
            // Définir la date formatée dans votre objet Transports
            $transpots->setObservation($observation);
            $this->transportRepository->add($transpots);

            return new JsonResponse(['message' => 'affectation a bien été affectée.'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            // Log the exception or handle it according to your needs

            dd($e->getMessage());

            return new JsonResponse(['error' => 'An error occurred.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/transports/new', name: 'edit_transport_liv_new')]
    public function new_transports(): Response
    {

        $transporteurs = $this->transporteurRepository->findAll();
        $chantiers_by_agence = $this->chantiersRepository->getAllChantiersEncours();
        $conducteur = $this->userRepository->getEmailsForRoleConducteurTraveaux()->getResult();

        return $this->render('transports/new.html.twig', [
            'controller_name' => 'TransportsController',
            'title' => 'Ajouter Transport',
            'transporteurs' => $transporteurs,
            'chantiers' => $chantiers_by_agence ,
            'conducteur' => $conducteur ,
            'transport' => null,
            'cdeEnteHeure' => "",
            'nav' => []
        ]);
    }

    #[Route('/ajouter/transport', name: 'app_transport_add')]
    public function add(Request $request): JsonResponse
    {
        try {
            $this->entityManagerInterface->beginTransaction();

            $sens = $request->request->get('sens');
            $commande_chantier = $request->request->get('commande_chantier');
            $poids = $request->request->get('poids');
            $commande_chantier_arrive =  $request->request->get('commande_chantier_arrive');
            $address_chantier = $request->request->get('address_chantier');
            $indication = $request->request->get('indication');
            $date_transport = $request->request->get('date_transport');
            $date_transport = DateTime::createFromFormat('Y-m-d', $date_transport);
            $heure_dep1_transport  = $request->request->get('heure_dep1_transport');
            $heureprev  = $request->request->get('heureprev');


           
            // Check if any of the required parameters are null, throw an exception if so
          

            $chantiersDepart  = $this->chantiersRepository->findByIdChantier($commande_chantier);
            $chantiersDepartarrive  = $this->chantiersRepository->findByIdNumChantier(1);
            $commande_chantier_arrive  = $this->chantiersRepository->findByIdChantier($commande_chantier_arrive);

            $transpots = new Transports();
            $transpots->setTypeTransport($sens);
            $transpots->setNumchantierdep($chantiersDepart);
            $transpots->setAdressechantier($address_chantier);
            $transpots->setPoidsbon($poids);
            $transpots->setVolume($indication);

            $transpots->setcreationAffectation(1);
            $transpots->setDateTransport($date_transport);


             // 

            switch ($sens) {
                case 1:
                    // Ce cas représente une option de Livraison
                    $transpots->setHeuredepart($heure_dep1_transport);
                    $transpots->setNumchantierdep($chantiersDepartarrive);
                    $transpots->setNumchantierarr($chantiersDepart);

                    break;
                case 2:
                    // Ce cas représente une option de Ramasse TY
                    $transpots->setHeuredepart($heure_dep1_transport);
                    $transpots->setNumchantierdep($chantiersDepart);
                    $transpots->setNumchantierarr($chantiersDepartarrive);

                    break;
                case 3:
                    // Ce cas représente une option de Ramasse TS
                    $transpots->setHeuredepart($heure_dep1_transport);
                    $transpots->setNumchantierdep($chantiersDepart);
                    $transpots->setNumchantierarr($chantiersDepartarrive);

                    break;
                case 4:
                    // Ce cas représente une option de Rotation
                    $transpots->setHeuredepart($heure_dep1_transport);
                    $transpots->setNumchantierdep($chantiersDepart);
                    $transpots->setNumchantierarr($chantiersDepart);
                    $transpots->setNbheuresprev($heureprev);

                    break;
                case 5:
                    // Ce cas représente une option de Transfert
                    $transpots->setHeuredepart($heure_dep1_transport);
                    $transpots->setNumchantierdep($chantiersDepart);
                    $transpots->setNumchantierarr($commande_chantier_arrive);

                    break;
                default:
                    // C'est l'option par défaut si aucune des précédentes ne correspond
              
                    break;
            }



            // Définir la date formatée dans votre objet Transports
            $event_id = $this->outlookService->addEventsTransport($transpots);
            $transpots->setEventTransportId($event_id);
            $this->entityManagerInterface->commit();

            $this->transportRepository->add($transpots);
            return new JsonResponse(['message' => 'Le transport a bien été créer.'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            // Log the exception or handle it according to your needs
            $this->entityManagerInterface->rollback();

            dd($e->getMessage());
            return new JsonResponse(['error' => 'An error occurred.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // detail transport 
    #[Route('/fiche-transport/{id}', name: 'fiche_transport')]
    public function fiche_transport(Transports $transports): Response
    {

       
        return $this->render('transports/fiche.html.twig', [
            'controller_name' => 'TransportsController',
            'title' => 'Transports',
            'transport' => $transports,
            'cdeEnteHeure' => "",
            'nav' => []
        ]);
    }

}
