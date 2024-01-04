<?php
// src/Service/OutlookService.php
namespace App\Service;

use Exception;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;

class OutlookService
{
    private $graph;
    private $client;
    private $accessToken;

    public function __construct(private string $clientId, private string $clientSecret, private string $tenantId)
    {
        $this->client = HttpClient::create();
        $this->accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6IjNGaDNPUE9ZMGY5cTdnT2FVczFJVWFzUHNlZEctMUJCOWlDMngxY3JFeEEiLCJhbGciOiJSUzI1NiIsIng1dCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSIsImtpZCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9lOTdjZjgwMy02ZDQ5LTQ0OGQtOTE5Mi1lOGMzNjc0YTIxZTgvIiwiaWF0IjoxNzA0MzU2NTIwLCJuYmYiOjE3MDQzNTY1MjAsImV4cCI6MTcwNDQ0MzIyMCwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFWUUFxLzhWQUFBQWk1cVFSQkU1NndjQTZGUmRjZVpqbHVSOFFYWDRjZWI5VXR1YTRlQXhXc2RjUWFhRjNWVUNHcXRQMG1IcXV1MitLN2JxZVlrYnlNODkyUDBmSkovTDg3ek5zNGpSTWgyajhMSlpjdU1lOC93PSIsImFtciI6WyJwd2QiLCJtZmEiXSwiYXBwX2Rpc3BsYXluYW1lIjoiR3JhcGggRXhwbG9yZXIiLCJhcHBpZCI6ImRlOGJjOGI1LWQ5ZjktNDhiMS1hOGFkLWI3NDhkYTcyNTA2NCIsImFwcGlkYWNyIjoiMCIsImZhbWlseV9uYW1lIjoiRWwgTWFtb3VuaSIsImdpdmVuX25hbWUiOiJTYWxhaCBFZGRpbmUiLCJpZHR5cCI6InVzZXIiLCJpcGFkZHIiOiIyYTAxOmUwYToxMDg6OWViMDpkNTZlOmEyMjQ6ZWRmMjphNThhIiwibmFtZSI6IlNhbGFoIEVkZGluZSBFbCBNYW1vdW5pIiwib2lkIjoiNzlmYTA1ZWItNThjOS00YzliLThjMDUtZGFhNGVlZDdjOGEwIiwicGxhdGYiOiIzIiwicHVpZCI6IjEwMDMyMDAyRjVCMjNBQjYiLCJyaCI6IjAuQVRFQUFfaDg2VWx0alVTUmt1akRaMG9oNkFNQUFBQUFBQUFBd0FBQUFBQUFBQUF4QUdNLiIsInNjcCI6IkNhbGVuZGFycy5SZWFkIENhbGVuZGFycy5SZWFkLlNoYXJlZCBDYWxlbmRhcnMuUmVhZEJhc2ljIENhbGVuZGFycy5SZWFkV3JpdGUgQ2FsZW5kYXJzLlJlYWRXcml0ZS5TaGFyZWQgRmlsZXMuUmVhZCBGaWxlcy5SZWFkLkFsbCBNYWlsLlJlYWQgTWFpbC5SZWFkQmFzaWMgTWFpbC5SZWFkV3JpdGUgb3BlbmlkIHByb2ZpbGUgVXNlci5SZWFkIGVtYWlsIiwic2lnbmluX3N0YXRlIjpbImttc2kiXSwic3ViIjoiclpfWVctX2JJWnhadm9DeDRmSHl1OFJtWUhjWEk4dl9ZbVZjdmZFNktKcyIsInRlbmFudF9yZWdpb25fc2NvcGUiOiJFVSIsInRpZCI6ImU5N2NmODAzLTZkNDktNDQ4ZC05MTkyLWU4YzM2NzRhMjFlOCIsInVuaXF1ZV9uYW1lIjoicy5lbG1hbW91bmlAajRyLmZyIiwidXBuIjoicy5lbG1hbW91bmlAajRyLmZyIiwidXRpIjoiRTZRbmxwVnVDa3FWMk5LcWFyaFpBZyIsInZlciI6IjEuMCIsIndpZHMiOlsiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19jYyI6WyJDUDEiXSwieG1zX3NzbSI6IjEiLCJ4bXNfc3QiOnsic3ViIjoiNHpPcGFwZUxYa1YzQzFFTGNUeDd0NTFUanNmNTVwSEhBMjY4Yi1NMDFBSSJ9LCJ4bXNfdGNkdCI6MTU0NTE0MzEzMSwieG1zX3RkYnIiOiJFVSJ9.amn9T_PgUDABJIP0-kq_-qS9OKVmwnv6PwKut7lQQtdT5ekDNxuqt8gwbl5E8IPfrKZRobz2vgglTVaFeUutZFRhEiDeqXRSIC04DS8OQA61vOh854QRZf5aLteYgmnOI9YDONcEJV87r6nI6QPOPkt2KA6Q_ZqVdR6EPsX-_9aguQEl21vbdCDl10YBEMAK8XxghM12mmMAGxHq0QDQZb6Nfzrtw5AFP177TShoJnozoT_e62xn5IL5svL3VV1F8VuUgfsvmX-hiGmOFGtUOlHgRfBUv08M5P7kpPvXbmV-SMeTI2hiFSq9kvTTCWHw_uWp_QuoD6oqPFD4whWSLA';
    }
    private function getAccessToken()
    {
        // Implement OAuth 2.0 authentication to get an access token.
        // Use the league/oauth2-client or a similar library for handling OAuth.
        // Return the access token obtained from the authentication process.

        // Mocked access token for demonstration purposes.

    }


    public function getCalendarEvents($start, $end)
    {
        $calendarId = 'AAMkADYzNmY1OWI1LWNmODctNDIwZS1hOGQ4LTM0MGRlNjdiZGYxMQBGAAAAAACGUiwjDrEAS5YH-q03p8iNBwCEynMLzVc4SLl5zEvxLDFlAAAAAAEGAACEynMLzVc4SLl5zEvxLDFlAAA7Ae9_AAA=';
        $startDateTime = $start . 'T00:00:00';
        $endDateTime = $end . 'T23:59:59';

        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/me/calendars('$calendarId')/calendarView?startDateTime=$startDateTime&endDateTime=$endDateTime&\$select=subject,start,end&\$orderby=start/dateTime&\$top=3000";

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
            echo 'Error: ' . $e->getMessage();
        }
    }
    public function addEvents($sujet, $date_debut, $date_fin, $location, $attachmentPath)
    {

        $graphApiEndpoint = 'https://graph.microsoft.com/v1.0/me/calendars/AAMkADYzNmY1OWI1LWNmODctNDIwZS1hOGQ4LTM0MGRlNjdiZGYxMQBGAAAAAACGUiwjDrEAS5YH-q03p8iNBwCEynMLzVc4SLl5zEvxLDFlAAAAAAEGAACEynMLzVc4SLl5zEvxLDFlAAA7Ae9_AAA=/events';

        $attachmentContent = file_get_contents($attachmentPath);


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
                'categories' => ['Affreter'], // Add the etiquette as a category

                'location' => [
                    'displayName' => $location,
                ],
                'attachments' => [
                    [
                        '@odata.type' => '#microsoft.graph.fileAttachment',
                        'name' => "lll",
                        'contentBytes' => base64_encode($attachmentContent),
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
}
