<?php
// src/Service/OutlookService.php
namespace App\Service;

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
    private $userId ; //depot@j4r.fr



    // injecter ParamAgenceRepository pour récuperer le token qui stocker sur Paramgence Table
    public function __construct(
    private ParamAgenceRepository $paramAgenceRepository)
    {
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

        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/users/".$this->userId."/calendars/".$calendarId."/calendarview?startDateTime=".$startDateTime."&endDateTime=".$endDateTime."&\$select=subject,start,end,location,categories&\$orderby=start/dateTime&\$top=3000";
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
     public function changeEvent_To_IBMValid($events_id){
        $this->accessToken = $this->paramAgenceRepository->getTokens();
        $categories = "IBM validé";
        $updatedEventData = array(
            'categories' => [$categories], // Add the etiquette as a category
        );
        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/users/".$this->userId."/events/".$events_id;
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



    public function addEvents($sujet, $date_debut, $date_fin, $location, $attachmentPath,$categories)
    {

        $graphApiEndpoint = 'https://graph.microsoft.com/v1.0/me/calendars/AAMkADYzNmY1OWI1LWNmODctNDIwZS1hOGQ4LTM0MGRlNjdiZGYxMQBGAAAAAACGUiwjDrEAS5YH-q03p8iNBwCEynMLzVc4SLl5zEvxLDFlAAAAAAEGAACEynMLzVc4SLl5zEvxLDFlAAA7Ae9_AAA=/events';

        $attachmentContent = file_get_contents($attachmentPath);


        if ($attachmentContent === false) {
            throw new Exception("Failed to read file content");
        }


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
                    'timeZone' => 'UTC',
                ],
                'end' => [
                    'dateTime' => $date_fin,
                    'timeZone' => 'UTC',
                ],
                'categories' => [$categories], // Add the etiquette as a category

                'location' => [
                    'displayName' => $location,
                ],
                'attachments' => [
                    [
                        '@odata.type' => '#microsoft.graph.fileAttachment',
                        'name' => "lll",
                        'contentBytes' => base64_encode($attachmentContent),
                        'contentType' => 'application/pdf',

                    ],
                    // Add more attachments as needed
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
    public function update(){
       
    }
}
