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
        $this->accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6InBlb3RQT0JoSmhDQnRjdy10ZEwwUV9iVzRVTlI0TXRnWHpTZGpueXRTTjQiLCJhbGciOiJSUzI1NiIsIng1dCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSIsImtpZCI6IjVCM25SeHRRN2ppOGVORGMzRnkwNUtmOTdaRSJ9.eyJhdWQiOiJodHRwczovL2dyYXBoLm1pY3Jvc29mdC5jb20iLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9lOTdjZjgwMy02ZDQ5LTQ0OGQtOTE5Mi1lOGMzNjc0YTIxZTgvIiwiaWF0IjoxNzA1Mzk3MDIwLCJuYmYiOjE3MDUzOTcwMjAsImV4cCI6MTcwNTQwMjA2NCwiYWNjdCI6MCwiYWNyIjoiMSIsImFjcnMiOlsidXJuOnVzZXI6cmVnaXN0ZXJzZWN1cml0eWluZm8iXSwiYWlvIjoiQVZRQXEvOFZBQUFBbkNGQ1ByMDRGdHUyWURqTGJwRWxFM2pod2lGUi9meGZzd3c1WGE1VlhPUmNVV1FTTEpNWXF0c1VFcW9RZXBEV2pTV2FUd0FLK3dnRWxVaCsxZWFzVmpIU1JNdnhQVXJPRk0zUllkQ3dyUUk9IiwiYW1yIjpbInB3ZCIsIm1mYSJdLCJhcHBfZGlzcGxheW5hbWUiOiJHcmFwaCBVc2VyIEF1dGggVHV0b3JpYWwiLCJhcHBpZCI6IjJmYmZiOWEyLTlmOTQtNDNmMS1hNjFlLWE5MTBiYmExOGY1NyIsImFwcGlkYWNyIjoiMCIsImZhbWlseV9uYW1lIjoiRWwgTWFtb3VuaSIsImdpdmVuX25hbWUiOiJTYWxhaCBFZGRpbmUiLCJpZHR5cCI6InVzZXIiLCJpcGFkZHIiOiIxOTMuMjUzLjI0OC4xNjIiLCJuYW1lIjoiU2FsYWggRWRkaW5lIEVsIE1hbW91bmkiLCJvaWQiOiI3OWZhMDVlYi01OGM5LTRjOWItOGMwNS1kYWE0ZWVkN2M4YTAiLCJwbGF0ZiI6IjMiLCJwdWlkIjoiMTAwMzIwMDJGNUIyM0FCNiIsInJoIjoiMC5BVEVBQV9oODZVbHRqVVNSa3VqRFowb2g2QU1BQUFBQUFBQUF3QUFBQUFBQUFBQXhBR00uIiwic2NwIjoiQ2FsZW5kYXJzLlJlYWRXcml0ZSBwcm9maWxlIG9wZW5pZCBlbWFpbCIsInNpZ25pbl9zdGF0ZSI6WyJrbXNpIl0sInN1YiI6InJaX1lXLV9iSVp4WnZvQ3g0Zkh5dThSbVlIY1hJOHZfWW1WY3ZmRTZLSnMiLCJ0ZW5hbnRfcmVnaW9uX3Njb3BlIjoiRVUiLCJ0aWQiOiJlOTdjZjgwMy02ZDQ5LTQ0OGQtOTE5Mi1lOGMzNjc0YTIxZTgiLCJ1bmlxdWVfbmFtZSI6InMuZWxtYW1vdW5pQGo0ci5mciIsInVwbiI6InMuZWxtYW1vdW5pQGo0ci5mciIsInV0aSI6IkR6SDhRTnJXakV1cUFMZV9BUm1HQUEiLCJ2ZXIiOiIxLjAiLCJ4bXNfc3QiOnsic3ViIjoiT3Q3bjNuVjBMZ19ZZ011aVNHSEZEUldfaDA3cG50SXY4dlhwVTNHMG9BSSJ9LCJ4bXNfdGNkdCI6MTU0NTE0MzEzMSwieG1zX3RkYnIiOiJFVSJ9.d-PbU4NN0D3to3JlLO0zJbGKJaCVuEHj5pnyQt-sEiGWJmlcsLF-D4ehkFgGSYtXrMNqX8WlJhT6GXgXRB9gYhMLEQJJl623AcyhkoZYd0aMq9RWbtGkp2SqsGiKNeqQ0u7A2MZT4tlXm6oiBr3NAny9Uyc6Rdg1VuJ3CCoVSqUoLtVMz2a5stigst2t6METEK5U0JySge1MPwqDadImvVv0GuoSv5mz6PRYPx9GMuosg0-9IsoijQ9DPU6d0aFPZtvmoVd-LKYL7cupuN6qKW1EWFW1NgtGmhZP7NoQBWlp-24KGDZJVb8OGVn5rL8Y6jg37gD1qot26104Lnaf0Q';
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
