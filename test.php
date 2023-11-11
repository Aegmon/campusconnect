<?php

require __DIR__ . '/google-api/vendor/autoload.php'; // Make sure to install the Google API client library

putenv('GOOGLE_APPLICATION_CREDENTIALS=credentials.json');

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setScopes(['https://www.googleapis.com/auth/calendar']);

$service = new Google_Service_Calendar($client);

// Create a new calendar event (Google Meet link will be generated)
$timeZone = 'Asia/Manila'; // Replace with your desired time zone, e.g., 'America/New_York'

try {
    // Create a new calendar event (Google Meet link will be generated)
    $event = new Google_Service_Calendar_Event([
        'summary' => 'Meeting Title',
        'description' => 'Google Meet created via PHP',
        'start' => [
            'dateTime' => '2023-12-31T10:00:00',
            'timeZone' => $timeZone,
        ],
        'end' => [
            'dateTime' => '2023-12-31T11:00:00',
            'timeZone' => $timeZone,
        ],
    ]);

    $calendarId = 'primary'; // You can use 'primary' for the primary calendar or specify your calendar ID
    $event = $service->events->insert($calendarId, $event);

    // Retrieve the Google Meet link from the inserted event
    $meetLink = $event->getHangoutLink();

    echo 'Google Meet created successfully! Link: ' . $meetLink;
} catch (Google_Service_Exception $e) {
    // Handle Google Service Exception
    echo 'Caught Google Service Exception: ', $e->getMessage(), "\n";
    // Print additional information for debugging
    print_r($e->getErrors());
} catch (Exception $e) {
    // Handle other exceptions
    echo 'Caught exception: ', $e->getMessage(), "\n";
}