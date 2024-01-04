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
        $this->accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6IlNtVXQzM1dUalY2OHJRTlloYUVzSnp6R3FiNTZsN0gyRDI2QTd2ZWoxT2MiLCJhbGciOiJSUzI1NiIsIng1dCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSIsImtpZCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9lOTdjZjgwMy02ZDQ5LTQ0OGQtOTE5Mi1lOGMzNjc0YTIxZTgvIiwiaWF0IjoxNzA0MjY5ODQwLCJuYmYiOjE3MDQyNjk4NDAsImV4cCI6MTcwNDM1NjU0MCwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFWUUFxLzhWQUFBQUxzSTRJNDdqWVRhWEpTblluZ1gwTHBmbEV6SWlPNTgyN3FSNXh6aDFRQkpBTFVleG1CQXdPblhIMUhUb3ZXajBVTGcwYk15SDE3QVgyenBPSGcxWVRmQk9XbFlMcDgwejRObzRtcHByekZVPSIsImFtciI6WyJwd2QiLCJtZmEiXSwiYXBwX2Rpc3BsYXluYW1lIjoiR3JhcGggRXhwbG9yZXIiLCJhcHBpZCI6ImRlOGJjOGI1LWQ5ZjktNDhiMS1hOGFkLWI3NDhkYTcyNTA2NCIsImFwcGlkYWNyIjoiMCIsImZhbWlseV9uYW1lIjoiRWwgTWFtb3VuaSIsImdpdmVuX25hbWUiOiJTYWxhaCBFZGRpbmUiLCJpZHR5cCI6InVzZXIiLCJpcGFkZHIiOiIyYTAxOmUwYToxMDg6OWViMDoyMTA2OmVhZDM6NDk3NTo3OWQzIiwibmFtZSI6IlNhbGFoIEVkZGluZSBFbCBNYW1vdW5pIiwib2lkIjoiNzlmYTA1ZWItNThjOS00YzliLThjMDUtZGFhNGVlZDdjOGEwIiwicGxhdGYiOiIzIiwicHVpZCI6IjEwMDMyMDAyRjVCMjNBQjYiLCJyaCI6IjAuQVRFQUFfaDg2VWx0alVTUmt1akRaMG9oNkFNQUFBQUFBQUFBd0FBQUFBQUFBQUF4QUdNLiIsInNjcCI6IkNhbGVuZGFycy5SZWFkIENhbGVuZGFycy5SZWFkLlNoYXJlZCBDYWxlbmRhcnMuUmVhZEJhc2ljIENhbGVuZGFycy5SZWFkV3JpdGUgQ2FsZW5kYXJzLlJlYWRXcml0ZS5TaGFyZWQgRmlsZXMuUmVhZCBGaWxlcy5SZWFkLkFsbCBNYWlsLlJlYWRCYXNpYyBvcGVuaWQgcHJvZmlsZSBVc2VyLlJlYWQgZW1haWwgTWFpbC5SZWFkV3JpdGUiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJyWl9ZVy1fYklaeFp2b0N4NGZIeXU4Um1ZSGNYSTh2X1ltVmN2ZkU2S0pzIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiZTk3Y2Y4MDMtNmQ0OS00NDhkLTkxOTItZThjMzY3NGEyMWU4IiwidW5pcXVlX25hbWUiOiJzLmVsbWFtb3VuaUBqNHIuZnIiLCJ1cG4iOiJzLmVsbWFtb3VuaUBqNHIuZnIiLCJ1dGkiOiIyT0lPbmZEYUtFaUwzLVBlYWNlYUFRIiwidmVyIjoiMS4wIiwid2lkcyI6WyJiNzlmYmY0ZC0zZWY5LTQ2ODktODE0My03NmIxOTRlODU1MDkiXSwieG1zX2NjIjpbIkNQMSJdLCJ4bXNfc3NtIjoiMSIsInhtc19zdCI6eyJzdWIiOiI0ek9wYXBlTFhrVjNDMUVMY1R4N3Q1MVRqc2Y1NXBISEEyNjhiLU0wMUFJIn0sInhtc190Y2R0IjoxNTQ1MTQzMTMxLCJ4bXNfdGRiciI6IkVVIn0.Q0--riDsnCkLgyTnQLVqhaXcEW0mArv3KRtYMmtjKSpJQ14oJC-C0kvJ33gHYp4cyGOavnyagh8Xsm1_0mAkVjQARoumihuP7S93NTEAQBqzH49WDszH6n39cbcUfg4PHRqQRBIRD36G6EQwWv6X2y8l07kH1EUSDnNgj8gRgjoWCdtPeMjWN6s3vC2TkskY9fRroDKzPT5E0MRNXipTanQxivuMv36jDWKjGVO8f5Xo3o-o4GfS9NEIAFx9z3UKQK2mq6da3Ec-mfGcmHFiWtBS3PSVZYomFRV9kXxT9qh3cGRRrXO7kA0qjjNvXIl_OXDU2qgrBdWYQaUR5jXA4A';
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
    public function addEvents($sujet, $date_debut, $date_fin, $location)
    {

        $graphApiEndpoint = 'https://graph.microsoft.com/v1.0/me/calendars/AAMkADYzNmY1OWI1LWNmODctNDIwZS1hOGQ4LTM0MGRlNjdiZGYxMQBGAAAAAACGUiwjDrEAS5YH-q03p8iNBwCEynMLzVc4SLl5zEvxLDFlAAAAAAEGAACEynMLzVc4SLl5zEvxLDFlAAA7Ae9_AAA=/events';


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
