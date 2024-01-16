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
            'title' => 'Planning transports ',
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
            $categories = $request->request->get('categories');

            $attachmentFile = $request->files->get('attachment');


            $response = $this->outlookService->addEvents($subject, $startDate, $endDate, $location, $attachmentFile, $categories);
            return $this->json($response);
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }


    #[Route('/token', name: 'token')]
    public function token(Request $request): Response
    {
        try {
            $clientId = '2fbfb9a2-9f94-43f1-a61e-a910bba18f57';
            $clientSecret = 'ezX8Q~PugbS.9Kv-BCj0dhnU6tlQ8Rb8Dq6BHat5';
            $tenantId = 'e97cf803-6d49-448d-9192-e8c3674a21e8'; //Locataire J4R uniquement
            $scope = 'https://graph.microsoft.com/Calendars.ReadWrite';
            $redirectUri = 'https://dev.crmj4r.fr/outlook/TestApiOutlook2.php';
            $authorizationUrl = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/v2.0/authorize'; // URL d'autorisation

            //Étape 1 : Obtenez le code d'autorisation en redirigeant l'utilisateur vers l'URL d'autorisation
            if (!isset($_GET['code'])) {
                $authUrl = $authorizationUrl . '?client_id=' . $clientId . '&response_type=token&scope=' . $scope . '&redirect_uri=' . urlencode($redirectUri) . '&response_mode=fragment&state=J4R77';
                header('Location: ' . $authUrl);
                exit;
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }
    #[Route('/outlook/TestApiOutlook2.php', name: 'outlouk_view')]
    public function outlouk(Request $request): Response
    {
        try {
            return $this->render('calendrier/outlouk.php');
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }
    #[Route('/save-token', name: 'save_token')]
    public function save_token(Request $request)
    {
        try {

            $apiUrl = 'https://graph.microsoft.com/v1.0/me/calendars'; // URL de l'API

            // Récupérez la chaîne de requête de l'URL actuelle
            $queryString = $_SERVER['QUERY_STRING'];

            // Analysez la chaîne de requête en un tableau associatif
            parse_str($queryString, $queryParams);

            // Récupérez le token d'accès s'il est présent
            if (isset($queryParams['access_token'])) {
                //Utilisez le token d'accès pour accéder à l'API
                $accesstoken = $queryParams['access_token'];
                $tokentype = $queryParams['token_type'];
                $expiresin = $queryParams['expires_in'];
                $scope = $queryParams['scope'];
                $state = $queryParams['state'];
                $sessionstate = $queryParams['session_state'];

                echo 'Token d\'acces : ' . $accesstoken . '<br>';
                echo 'Token Type : ' . $tokentype . '<br>';
                echo 'Expire In : ' . $expiresin . '<br>';
                echo 'scope : ' . $scope . '<br>';
                echo 'state : ' . $state . '<br>';
                echo 'session_state : ' . $sessionstate . '<br>';

               
            }
            dd("dd");
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }
}
