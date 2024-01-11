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
        $this->accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6Ik91a0VlVEVXS08td0VtYU1SdUZ2TFdVMVREU2ZXZm4wbWd3N2R2X3JPTGMiLCJhbGciOiJSUzI1NiIsIng1dCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSIsImtpZCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9lOTdjZjgwMy02ZDQ5LTQ0OGQtOTE5Mi1lOGMzNjc0YTIxZTgvIiwiaWF0IjoxNzA0OTYzODc3LCJuYmYiOjE3MDQ5NjM4NzcsImV4cCI6MTcwNTA1MDU3NywiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFWUUFxLzhWQUFBQWhzRVdEVnFOMjYvcHZ3QXlQNkdERkJJdzJoclRLaXE3THJScm9Ec2dEaDdNYnBwUEN2eU9QM1F6S2doWlByWjBLcHZWY2ZhazR6L3pvcUNrQjZWRjlmKytKeXpUM1NoVmJSaUsxcElIVU8wPSIsImFtciI6WyJwd2QiLCJtZmEiXSwiYXBwX2Rpc3BsYXluYW1lIjoiR3JhcGggRXhwbG9yZXIiLCJhcHBpZCI6ImRlOGJjOGI1LWQ5ZjktNDhiMS1hOGFkLWI3NDhkYTcyNTA2NCIsImFwcGlkYWNyIjoiMCIsImZhbWlseV9uYW1lIjoiRWwgTWFtb3VuaSIsImdpdmVuX25hbWUiOiJTYWxhaCBFZGRpbmUiLCJpZHR5cCI6InVzZXIiLCJpcGFkZHIiOiIxOTMuMjUzLjI0OC4xNjIiLCJuYW1lIjoiU2FsYWggRWRkaW5lIEVsIE1hbW91bmkiLCJvaWQiOiI3OWZhMDVlYi01OGM5LTRjOWItOGMwNS1kYWE0ZWVkN2M4YTAiLCJwbGF0ZiI6IjMiLCJwdWlkIjoiMTAwMzIwMDJGNUIyM0FCNiIsInJoIjoiMC5BVEVBQV9oODZVbHRqVVNSa3VqRFowb2g2QU1BQUFBQUFBQUF3QUFBQUFBQUFBQXhBR00uIiwic2NwIjoiQ2FsZW5kYXJzLlJlYWQgQ2FsZW5kYXJzLlJlYWQuU2hhcmVkIENhbGVuZGFycy5SZWFkQmFzaWMgQ2FsZW5kYXJzLlJlYWRXcml0ZSBDYWxlbmRhcnMuUmVhZFdyaXRlLlNoYXJlZCBGaWxlcy5SZWFkIEZpbGVzLlJlYWQuQWxsIE1haWwuUmVhZCBNYWlsLlJlYWRCYXNpYyBNYWlsLlJlYWRXcml0ZSBvcGVuaWQgcHJvZmlsZSBVc2VyLlJlYWQgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJyWl9ZVy1fYklaeFp2b0N4NGZIeXU4Um1ZSGNYSTh2X1ltVmN2ZkU2S0pzIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiZTk3Y2Y4MDMtNmQ0OS00NDhkLTkxOTItZThjMzY3NGEyMWU4IiwidW5pcXVlX25hbWUiOiJzLmVsbWFtb3VuaUBqNHIuZnIiLCJ1cG4iOiJzLmVsbWFtb3VuaUBqNHIuZnIiLCJ1dGkiOiJLVUtseXB2NVZFZWFJUktiWXp4UEF3IiwidmVyIjoiMS4wIiwid2lkcyI6WyJiNzlmYmY0ZC0zZWY5LTQ2ODktODE0My03NmIxOTRlODU1MDkiXSwieG1zX2NjIjpbIkNQMSJdLCJ4bXNfc3NtIjoiMSIsInhtc19zdCI6eyJzdWIiOiI0ek9wYXBlTFhrVjNDMUVMY1R4N3Q1MVRqc2Y1NXBISEEyNjhiLU0wMUFJIn0sInhtc190Y2R0IjoxNTQ1MTQzMTMxLCJ4bXNfdGRiciI6IkVVIn0.R_UVPT7ZUC3_61MAcNVOzs-9II6eHrCIYZgxKUbmxZhUgUZmUiHZXO3oz6S3EofFKBAxQUUmLsjHCVzQrSj37JnPFqFSA5OdOLAVf_HcYm0cPDE5Gqx_ElCA0IVyCsu1RTn4saFuLhGd7QDNlsOvK5tpN7nNpRlSh2iGQQu8GmcvjNCYKeovOU5I71HXsUldSNnTPaEK0e8Vum16-9G4P2YBhztQibbMH4HGavwQ8y5EInD-5yS5NIceQIlUYbTbvjr2r58PxGvvmQ7H5XO9X-Od3BO7rQ4FHEG6Fi0N742RmchRBDmYCZgU-3Wr-COpI1unjsJ1Iq1f5X4nUwyNeA';
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
