#Fully object oriented api for PromoSMS.pl service

Following code is example how to send sms, check account balance and get delivery report.

```
<?php

require __DIR__ . '/vendor/autoload.php';

use PromoSMS\Api\Client;
use PromoSMS\Api\Sms\Sms;

$client = new Client('norbert@orzechowicz.pl', md5('norbert124'));

echo "Current account balance is: " . $client->balance()->getAmount() / 100 . "\n";

$sms = new Sms();
$sms->setReceiver('661925557');
$sms->setMessage('This new message');

$response = $client->send($sms);

if ($response->isValid()) {
    // Get sms delivery report
    $report = $client->report($response->getId());
    echo "SMS id: " . $response->getId() . "\n";

    if ($report->isReceived()) {
        echo "SMS was received at: " . $report->getTime()->format('Y-m-d H:i:s') . "\n";
    } else {
        echo "SMS wasn't received yet. Please check later.\n";
    }

} else {
    // If something went wrong check the status
    // Full status list is available here: http://dev.promosms.pl/sms-api/HTTP_SSL_API#Statusy_zwracane_przez_system
    echo $response->getStatus();
}

echo "Current account balance is: " . $client->balance()->getAmount() / 100 . "\n";

```