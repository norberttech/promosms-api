#Fully object oriented api for PromoSMS.pl service

Api is under development and you can't use it or even install by composer.
Following code is example how you will be able to use it after release.

```
<?php

require __DIR__ . '/vendor/autoload.php';

use PromoSMS\Api\Client;
use PromoSMS\Api\Sms\Sms;

$client = new Client('login@email.com', md5('password'));

$sms = new Sms();
$sms->setReceiver('123123123');
$sms->setMessage('This is message content');

$response = $client->send($sms);

if ($response->isValid()) {
    $report = $client->report($response->getId());

    echo "Delivery status: " . $report->getStatus();
} else {
    echo $response->getStatus();
}

```