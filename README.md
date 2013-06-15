#Fully object oriented api for PromoSMS.pl service

Api is under development and you can't use it or even install by composer.
Following code is example how you will be able to use it after release.

```
<?php

use PromoSMS\Api\Client;
use PromoSMS\Api\Sms\Sms;

$client = new Client('email@domain.com', md5('password'));

$sms = new Sms();
$sms->setReceiver('123123123');
$sms->setMessage('SMS message');

$response = $client->send($sms);

if ($response->isValid()) {
    echo "SMS id: " . $response->getId() . "\n";
} else {

}

```