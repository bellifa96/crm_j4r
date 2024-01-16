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
        $this->accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6IlhSN0pza3M4aU93UXF0ZVA1aTJuOHBTREV4amRwT3ZuTTNRSzdlSXhfQjgiLCJhbGciOiJSUzI1NiIsIng1dCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSIsImtpZCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSJ9.eyJhdWQiOiJodHRwczovL2dyYXBoLm1pY3Jvc29mdC5jb20iLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9lOTdjZjgwMy02ZDQ5LTQ0OGQtOTE5Mi1lOGMzNjc0YTIxZTgvIiwiaWF0IjoxNzA1NDA3Mjg5LCJuYmYiOjE3MDU0MDcyODksImV4cCI6MTcwNTQxMjMwNiwiYWNjdCI6MCwiYWNyIjoiMSIsImFjcnMiOlsidXJuOnVzZXI6cmVnaXN0ZXJzZWN1cml0eWluZm8iXSwiYWlvIjoiQVRRQXkvOFZBQUFBNEpwS0JaaFR5UWk4dlFyd0dpK2FLZ2pRc25HMEk1M0VZcU9KS2lEaE4ySWVHWjFkNmlpa1hpWDRyVkJubUpjdiIsImFtciI6WyJwd2QiXSwiYXBwX2Rpc3BsYXluYW1lIjoiR3JhcGggVXNlciBBdXRoIFR1dG9yaWFsIiwiYXBwaWQiOiIyZmJmYjlhMi05Zjk0LTQzZjEtYTYxZS1hOTEwYmJhMThmNTciLCJhcHBpZGFjciI6IjAiLCJmYW1pbHlfbmFtZSI6IkVsIE1hbW91bmkiLCJnaXZlbl9uYW1lIjoiU2FsYWggRWRkaW5lIiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiMTkzLjI1My4yNDguMTYyIiwibmFtZSI6IlNhbGFoIEVkZGluZSBFbCBNYW1vdW5pIiwib2lkIjoiNzlmYTA1ZWItNThjOS00YzliLThjMDUtZGFhNGVlZDdjOGEwIiwicGxhdGYiOiIzIiwicHVpZCI6IjEwMDMyMDAyRjVCMjNBQjYiLCJyaCI6IjAuQVRFQUFfaDg2VWx0alVTUmt1akRaMG9oNkFNQUFBQUFBQUFBd0FBQUFBQUFBQUF4QUdNLiIsInNjcCI6IkNhbGVuZGFycy5SZWFkV3JpdGUgcHJvZmlsZSBvcGVuaWQgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJyWl9ZVy1fYklaeFp2b0N4NGZIeXU4Um1ZSGNYSTh2X1ltVmN2ZkU2S0pzIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiZTk3Y2Y4MDMtNmQ0OS00NDhkLTkxOTItZThjMzY3NGEyMWU4IiwidW5pcXVlX25hbWUiOiJzLmVsbWFtb3VuaUBqNHIuZnIiLCJ1cG4iOiJzLmVsbWFtb3VuaUBqNHIuZnIiLCJ1dGkiOiI3d185Y3cxYTJrS2JJVDN6UXVWNkFBIiwidmVyIjoiMS4wIiwieG1zX3N0Ijp7InN1YiI6Ik90N24zblYwTGdfWWdNdWlTR0hGRFJXX2gwN3BudEl2OHZYcFUzRzBvQUkifSwieG1zX3RjZHQiOjE1NDUxNDMxMzEsInhtc190ZGJyIjoiRVUifQ.cFPEQfMRGxO2RzOcqAj_93OoAHdPGr0hESpQ9pKbjrg01xaZ-khnWNZCqY1PMn3B6PZFz44wl9Iyz4hNR9_OFNTa4nfxvx_YgPyMU4egmdNKZRofP-AXrOhFQ5nRcS16q4b90-cM8AOg5uWobEhLLIVVlKdNGVthW5YiteKibDKY8tbgj1k2PLvUPzat2WkIvkb18iPotYtlH4spRnXADujyMhL0ndn72u9StWTpplVEo9jG5sgM3aiK5bPxeL5M7ZyRYYQ9iIF0Gcp7X7ggLs-FMHof8qwKZr_nkdUD-W4ZhDOOjLXcmjLqCb7lJyGpbo1jGGXaZ1aNdZk_3FzBQg';
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

        $graphApiEndpoint = "https://graph.microsoft.com/v1.0/me/calendars('$calendarId')/calendarView?startDateTime=$startDateTime&endDateTime=$endDateTime&\$select=subject,start,end,location,categories&\$orderby=start/dateTime&\$top=3000";

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
