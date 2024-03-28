<?php
// src/Service/OutlookService.php
namespace App\Service;

use App\Entity\Affaire\Transport;
use App\Entity\Depot\Transports;
use App\Entity\Transport\CdeMatEnt;
use App\Repository\Depot\ParamAgenceRepository;
use Exception;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
/* OutlookService cette class pour communiquer avec microsoft 350 (Calendrier,SharePoint  .... )
**/

class OutlookService
{
    private $client;
    private $accessToken;
    private $userId; //depot@j4r.fr

    private $CalendarId = "AAMkADU3MDRkNmI4LTM1NTUtNGNmMS1hMzEwLTBjOTYxMjU2M2ViMwAuAAAAAAAhabwJHj2dQbJDtMwJcRmzAQAK7FnT_2tgTaAsVzxSi0cLAACc8k4LAAA=";



    // injecter ParamAgenceRepository pour récuperer le token qui stocker sur Paramgence Table
    public function __construct(
        private ParamAgenceRepository $paramAgenceRepository
    ) {
        $this->client = HttpClient::create();
        $this->accessToken = '';
        $this->userId = "64b4f5f5-6741-4d7c-873c-0cdc64eff509";
    }




    /* cette methode pour recuperer les calendarEvents entre deux date
    */
    public function getCalendarEvents($start, $end)
    {
        // récuperer token
        $this->accessToken = $this->paramAgenceRepository->getTokens();

        // id Calendar sur microsodt
        $calendarId = 'AAMkADU3MDRkNmI4LTM1NTUtNGNmMS1hMzEwLTBjOTYxMjU2M2ViMwAuAAAAAAAhabwJHj2dQbJDtMwJcRmzAQAK7FnT_2tgTaAsVzxSi0cLAACc8k4LAAA=';
        $startDateTime = $start . 'T00:00:00';
        $endDateTime = $end . 'T23:59:59';

        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/users/" . $this->userId . "/calendars/" . $calendarId . "/calendarview?startDateTime=" . $startDateTime . "&endDateTime=" . $endDateTime . "&\$select=subject,start,end,location,categories&\$orderby=start/dateTime&\$top=3000";
        try {
            // Make the GET request to the Microsoft Graph API
            $response = $this->client->request('GET', $graphApiEndpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            // Get the JSON response
            $data = $response->toArray();

            // Process the response data as needed
            return $data;
        } catch (ExceptionInterface $e) {
            // Handle exceptions
            return null;
        }
    }

    // modifier IBM Validé 
    public function changeEvent_To_IBMValid($events_id,$date)
    {
       
        $this->accessToken = $this->paramAgenceRepository->getTokens();
        $categories = "IBM validé";

       

        $updatedEventData = array(
            'categories' => [$categories], // Ajouter l'étiquette en tant que catégorie
            'start' => array(
                'dateTime' => $date->format('Y-m-d\TH:i:s'),
                'timeZone' => 'Europe/Paris',
            ),
            'end' => array(
                'dateTime' => $date->format('Y-m-d\TH:i:s'),
                'timeZone' => 'Europe/Paris',
            ),
        );

        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/users/" . $this->userId . "/events/" . $events_id;
        $response = $this->client->request('PATCH', $graphApiEndpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $updatedEventData, // Envoyer les données de l'événement mises à jour en tant que charge utile JSON
        ]);

        if ($response->getStatusCode() == 200) {
            // Événement mis à jour avec succès
            return true;
        } else {
            // Erreur lors de la mise à jour de l'événement
            return false;
        }
    }


    // ajourner
    public function archive_calendar_ajourner($events_id)
    {
        $this->accessToken = $this->paramAgenceRepository->getTokens();
        $categories = "Ajourner";
        $updatedEventData = array(
            'categories' => [$categories], // Add the etiquette as a category
        );
        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/users/" . $this->userId . "/events/" . $events_id;
        $response = $this->client->request('PATCH', $graphApiEndpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $updatedEventData, // Send updated event data as JSON payload

        ]);

        if ($response->getStatusCode() == 200) {
            // Event updated successfully
            return true;
        } else {
            // Error updating event
            return false;
        }
    }

    public function des_archive_calendar_ajourner($events_id)
    {
        $this->accessToken = $this->paramAgenceRepository->getTokens();
        $categories = "Demande Cdt";
        $updatedEventData = array(
            'categories' => [$categories], // Add the etiquette as a category
        );
        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/users/" . $this->userId . "/events/" . $events_id;
        $response = $this->client->request('PATCH', $graphApiEndpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $updatedEventData, // Send updated event data as JSON payload

        ]);

        if ($response->getStatusCode() == 200) {
            // Event updated successfully
            return true;
        } else {
            // Error updating event
            return false;
        }
    }
    // modifier Affrete aprés affectation transport

    public function change_to_affreter($events_id, $additionalWord,$date)
    {
        $this->accessToken = $this->paramAgenceRepository->getTokens();

        // Étape 1: Obtenir le sujet actuel de l'événement
        $graphApiEndpointGet = "https://graph.microsoft.com/v1.0/users/" . $this->userId . "/events/" . $events_id;
        $responseGet = $this->client->request('GET', $graphApiEndpointGet, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
        ]);
        $sujet = "";
        if ($responseGet->getStatusCode() == 200) {
            $content = $responseGet->getContent(); // Pour les réponses 2xx
            $eventDetails = json_decode($content, true);
            $sujet = $eventDetails['subject'];
        } else {
            // Gérer l'erreur si l'événement ne peut pas être récupéré
            return false;
        }

        $parties = explode("-", $sujet);

        // Récupère le dernier élément du tableau
        $numero = trim(end($parties));

        // Vérifie si le numéro contient "No"
        if (strpos($numero, "No") !== false) { // Utilisez "!== false" pour une comparaison stricte
            $parties[] = $additionalWord;
        } else {
            $parties[count($parties) - 1] = $additionalWord;

            // Ajoutez "ESG" au tableau des parties
        }

        // Rejoint les parties en utilisant le délimiteur "-"
        $sujet = implode("-", $parties);


        // Étape 2: Ajouter un mot au sujet
        $updatedSubject = $sujet;

        // Étape 3: Mettre à jour l'événement avec le nouveau sujet
        $categories = "Affreter";
        $updatedEventData = array(
            'subject' => $updatedSubject, // Utiliser le sujet mis à jour
            'categories' => [$categories],
            'start' => [
                'dateTime' => $date->format('Y-m-d\TH:i:s'),
                'timeZone' => 'Europe/Paris',
            ],
            'end' => [
                'dateTime' => $date->format('Y-m-d\TH:i:s'),
                'timeZone' => 'Europe/Paris',
            ],
            
        );
        $graphApiEndpointPatch = "https://graph.microsoft.com/v1.0/users/" . $this->userId . "/events/" . $events_id;
        $responsePatch = $this->client->request('PATCH', $graphApiEndpointPatch, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $updatedEventData,
        ]);

        if ($responsePatch->getStatusCode() == 200) {
            // L'événement a été mis à jour avec succès
            return true;
        } else {
            // Gérer l'erreur si la mise à jour de l'événement échoue
            return false;
        }
    }





    public function addEvents($sujet, $date_debut, $date_fin, $location, $categories)
    {


        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/users/" . $this->userId . "/calendars/" . $this->CalendarId . "/events";




        // Create an HTTP client instance

        // Make the POST request to create an event
        $response = $this->client->request('POST', $graphApiEndpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'subject' => $sujet,
                'start' => [
                    'dateTime' => $date_debut,
                    'timeZone' => 'Europe/Paris',
                ],
                'end' => [
                    'dateTime' => $date_fin,
                    'timeZone' => 'Europe/Paris',
                ],
                'categories' => [$categories], // Add the etiquette as a category

                'location' => [
                    'displayName' => $location,
                ],

            ],
        ]);

        // Check the response status
        if ($response->getStatusCode() === 201) {
            // Event created successfully
            return $response->getStatusCode();
        } else {
            // Handle error
            return $response->getStatusCode();
            // Optionally, you can also print the response content for debugging purposes
            // echo $response->getContent();
        }
    }

    public function update()
    {
    }
    public function addEventsCommande(CdeMatEnt $cdeMatEnt)
    {
        // Assuming $this->client is already set up and $this->accessToken, $this->userId, $sujet, $date_debut, $date_fin, $categories, and $location are defined
        $this->accessToken = $this->paramAgenceRepository->getTokens();
        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/users/" . $this->userId . "/calendars/" . $this->CalendarId . "/events";
        // Make the POST request to create an event
        $response = $this->client->request('POST', $graphApiEndpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'subject' => 'LIV - ' . $cdeMatEnt->getChantier()->getClient() . '-' . $cdeMatEnt->getChantier()->getVille(),
                'start' => [
                    'dateTime' => $cdeMatEnt->getDateEnlevDem()->format('Y-m-d\TH:i:s'),
                    'timeZone' => 'Europe/Paris',
                ],
                'end' => [
                    'dateTime' => $cdeMatEnt->getDateEnlevDem()->format('Y-m-d\TH:i:s'),
                    'timeZone' => 'Europe/Paris',
                ],
                "Body" => array(
                    "ContentType" => "HTML",
                    "Content" =>  $cdeMatEnt->getCommentaires1() . ' ' . $cdeMatEnt->getCommentaires2()
                ),
                'categories' => ["Demande Cdt"], // Add the etiquette as a category
                'location' => [
                    'displayName' => $cdeMatEnt->getAdresseChantier(),
                ],
            ],
        ]);

        // Check the response status
        if ($response->getStatusCode() === 201) {
            // Event created successfully, decode JSON to get the event ID
            $responseData = json_decode($response->getContent(), true);
            $eventId = $responseData['id']; // Extract the event ID from the response data
            return $eventId;
        } else {
            // Handle error
            // Optionally, you can print the response status code or content for debugging
            // return $response->getStatusCode();
            // echo $response->getContent();
            throw new \Exception('Failed to create event: ' . $response->getContent());
        }
    }

    public function addEventsTransport(Transports $transports,$combinedDateTime)
    {
        // Assuming $this->client is already set up and $this->accessToken, $this->userId, $sujet, $date_debut, $date_fin, $categories, and $location are defined
        $this->accessToken = $this->paramAgenceRepository->getTokens();
        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/users/" . $this->userId . "/calendars/" . $this->CalendarId . "/events";
        $sujet = $this->make_sujet_calendar($transports);
        // Make the POST request to create an event
        $response = $this->client->request('POST', $graphApiEndpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'subject' => $sujet,
                'start' => [
                    'dateTime' => $combinedDateTime->format('Y-m-d\TH:i:s'),
                    'timeZone' => 'Europe/Paris',
                ],
                'end' => [
                    'dateTime' => $combinedDateTime->format('Y-m-d\TH:i:s'),
                    'timeZone' => 'Europe/Paris',
                ],

                'categories' => ["Demande Cdt"], // Add the etiquette as a category
                'location' => [
                    'displayName' => $transports->getAdresseChantier(),
                ],
            ],
        ]);

        // Check the response status
        if ($response->getStatusCode() === 201) {
            // Event created successfully, decode JSON to get the event ID
            $responseData = json_decode($response->getContent(), true);
            $eventId = $responseData['id']; // Extract the event ID from the response data
            return $eventId;
        } else {
            // Handle error
            // Optionally, you can print the response status code or content for debugging
            // return $response->getStatusCode();
            // echo $response->getContent();
            throw new \Exception('Failed to create event: ' . $response->getContent());
        }
    }
    public function modifierEvenetTransport(Transports $transports,$date)
    {
        try {


            // Assuming $this->client is already set up and $this->accessToken, $this->userId, $sujet, $date_debut, $date_fin, $categories, and $location are defined
            $this->accessToken = $this->paramAgenceRepository->getTokens();
            $graphApiEndpointGet = "https://graph.microsoft.com/v1.0/users/" . $this->userId . "/events/" . $transports->getEventTransportId();
            $sujet = $this->make_sujet_calendar_lors_modification($transports);
            // Make the POST request to create an event
            $response = $this->client->request('PATCH', $graphApiEndpointGet, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'subject' => $sujet,
                    'start' => [
                        'dateTime' => $date->format('Y-m-d\TH:i:s'),
                        'timeZone' => 'Europe/Paris',
                    ],
                    'end' => [
                        'dateTime' => $date->format('Y-m-d\TH:i:s'),
                        'timeZone' => 'Europe/Paris',
                    ],

                    'categories' => ["Affreter"], // Add the etiquette as a category
                    'location' => [
                        'displayName' => $transports->getAdresseChantier(),
                    ],
                ],
            ]);

            // Check the response status
            if ($response->getStatusCode() === 201) {
                // Event created successfully, decode JSON to get the event ID
                $responseData = json_decode($response->getContent(), true);
                $eventId = $responseData['id']; // Extract the event ID from the response data
                return $eventId;
            } else {
                // Handle error
                // Optionally, you can print the response status code or content for debugging
                // return $response->getStatusCode();
                // echo $response->getContent();
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function make_sujet_calendar(Transports $transports)
    {
        $type_transport = $transports->getTypeTransport();
        switch ($type_transport) {
            case 1:
                return "LIV -" . $transports->getNumchantierdep()->getNomchantier() . '-';
            case 2:
                // code block for case 2
                return "RAM TY -" . $transports->getNumchantierdep()->getNomchantier() . '-';
            case 3:
                // code block for case 3
                return "RAM TS -" . $transports->getNumchantierdep()->getNomchantier() . '-';
            case 4:
                // code block for case 4
                return "ROT -" . $transports->getNumchantierdep()->getNomchantier() . '-';
            case 5:
                // code block for case 5
                return "TRANS -" . $transports->getNumchantierdep()->getNomchantier() . '-';
            default:
                // code block for default case
        }
    }
    public function make_sujet_calendar_lors_modification(Transports $transports)
    {
        $sujet = $this->make_sujet_calendar($transports);
        if ($transports->getIdtransporteur() != null) {
            return $sujet . ' ' . $transports->getIdtransporteur()->getSociete();
        }
    }
}
