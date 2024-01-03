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
        $this->accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6Il8yRUM4WENCMFI0dkFzdGJSaERjTlVjWENYazJvZ2NxN0JUMjV1U2thaWMiLCJhbGciOiJSUzI1NiIsIng1dCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSIsImtpZCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9lOTdjZjgwMy02ZDQ5LTQ0OGQtOTE5Mi1lOGMzNjc0YTIxZTgvIiwiaWF0IjoxNzA0MjEwOTcxLCJuYmYiOjE3MDQyMTA5NzEsImV4cCI6MTcwNDI5NzY3MSwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFWUUFxLzhWQUFBQVd0ZjdTTFRkdlZtU2JxOWtnaU9NVzYwQUoxVUFGcEY0bDRqVTBTSzM4eFhSTmYxYUROY0lweUpyV3ZJTDY0aStpN1ZNbGNrc2xxbVVDUTZ1K2xUL2VXa3hIQ1gwSjFOajFiUzFpTjlvOUlJPSIsImFtciI6WyJwd2QiLCJtZmEiXSwiYXBwX2Rpc3BsYXluYW1lIjoiR3JhcGggRXhwbG9yZXIiLCJhcHBpZCI6ImRlOGJjOGI1LWQ5ZjktNDhiMS1hOGFkLWI3NDhkYTcyNTA2NCIsImFwcGlkYWNyIjoiMCIsImZhbWlseV9uYW1lIjoiRWwgTWFtb3VuaSIsImdpdmVuX25hbWUiOiJTYWxhaCBFZGRpbmUiLCJpZHR5cCI6InVzZXIiLCJpcGFkZHIiOiIyYTAxOmUwYToxMDg6OWViMDo1MWFiOjM2Zjo3MmI2OjI0NzEiLCJuYW1lIjoiU2FsYWggRWRkaW5lIEVsIE1hbW91bmkiLCJvaWQiOiI3OWZhMDVlYi01OGM5LTRjOWItOGMwNS1kYWE0ZWVkN2M4YTAiLCJwbGF0ZiI6IjMiLCJwdWlkIjoiMTAwMzIwMDJGNUIyM0FCNiIsInJoIjoiMC5BVEVBQV9oODZVbHRqVVNSa3VqRFowb2g2QU1BQUFBQUFBQUF3QUFBQUFBQUFBQXhBR00uIiwic2NwIjoiQ2FsZW5kYXJzLlJlYWQgQ2FsZW5kYXJzLlJlYWQuU2hhcmVkIENhbGVuZGFycy5SZWFkQmFzaWMgQ2FsZW5kYXJzLlJlYWRXcml0ZSBvcGVuaWQgcHJvZmlsZSBVc2VyLlJlYWQgZW1haWwgQ2FsZW5kYXJzLlJlYWRXcml0ZS5TaGFyZWQiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJyWl9ZVy1fYklaeFp2b0N4NGZIeXU4Um1ZSGNYSTh2X1ltVmN2ZkU2S0pzIiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkVVIiwidGlkIjoiZTk3Y2Y4MDMtNmQ0OS00NDhkLTkxOTItZThjMzY3NGEyMWU4IiwidW5pcXVlX25hbWUiOiJzLmVsbWFtb3VuaUBqNHIuZnIiLCJ1cG4iOiJzLmVsbWFtb3VuaUBqNHIuZnIiLCJ1dGkiOiJfT1Zua2p0XzMwU0tMM3VhdnFMX0FRIiwidmVyIjoiMS4wIiwid2lkcyI6WyJiNzlmYmY0ZC0zZWY5LTQ2ODktODE0My03NmIxOTRlODU1MDkiXSwieG1zX2NjIjpbIkNQMSJdLCJ4bXNfc3NtIjoiMSIsInhtc19zdCI6eyJzdWIiOiI0ek9wYXBlTFhrVjNDMUVMY1R4N3Q1MVRqc2Y1NXBISEEyNjhiLU0wMUFJIn0sInhtc190Y2R0IjoxNTQ1MTQzMTMxLCJ4bXNfdGRiciI6IkVVIn0.LBKq5qpSdDTn_Wex_Er-ZU2Bp0-WG1OOTtOeLzh3zhdXB8V3Rx0UpiCGXE2KvlZ5xAnFtHCMpcAK70PaIpEmVB_fxafZ2Anp6dpHO2r9hT8K8lTbO7MMwI4WmXOP-m_SmPUS7tjM8MIgUSMtD2NI29RBu3u8fdZYS25zQ4-WCCMyJwuPoBecm3pImmL_Rm2BS6-LTBP_GVwi7SPqlS0JVLgKGi9dn2ra2xzW62KfnKYgeXmS5ZFsqqqQgSuS_BCvsfWdKut7qxsKmoCRDBJjezomqj8lAi5wLtV7AjOxjFZeoJVKwVvZNb_6iob2cgTsORHLGMW0nGlUCrrIQe6Igw';
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
    public function addEvents($event)
    {
        $calendarId = 'AAMkADYzNmY1OWI1LWNmODctNDIwZS1hOGD4LTM0MGRlNjdiZGYxMQBGAAAAAACGUiwjDrEAS5YH-q03p8iNBwCEynMLzVc4SLl5zEvxLDFlAAAAAAEGAACEynMLzVc4SLl5zEvxLDFlAAA7Ae9_AAA=';

        $graphApiEndpoint = 'https://graph.microsoft.com/v1.0/me/calendars/' . rawurlencode($calendarId) . '/events';

        try {
            // Create an HTTP client instance
            $httpClient = HttpClient::create();

            // Make the POST request to create an event
            $response = $httpClient->request('POST', $graphApiEndpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'subject' => 'Meeting with Client',
                    'body' => [
                        'content' => 'Discuss upcoming transportation plans',
                        'contentType' => 'HTML',
                    ],
                    'start' => [
                        'dateTime' => '2024-01-02T14:00:00',
                        'timeZone' => 'UTC',
                    ],
                    'end' => [
                        'dateTime' => '2024-01-02T15:00:00',
                        'timeZone' => 'UTC',
                    ],
                    'location' => [
                        'displayName' => 'Conference Room 123',
                    ],
                ],
            ]);

            // Get the JSON response
            $data = $response->toArray();

            // Process the response data as needed
            var_dump($data);
        } catch (HttpExceptionInterface $e) {
            // Handle HTTP exceptions
            echo 'HTTP Exception: ' . $e->getMessage();
        } catch (\Exception $e) {
            // Handle other exceptions
            echo 'Exception: ' . $e->getMessage();
        }
    }
}
