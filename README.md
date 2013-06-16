#Fully object oriented api for PromoSMS.pl service

Api is under development but you can install it via composer.

```yml
"require": {
    "norzechowicz/promosms-api": "1.0.x-dev"
}
```

Following code is an example how to send sms and get delivery report.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use PromoSMS\Api\Client;
use PromoSMS\Api\Sms\Sms;

$client = new Client('login@email.com', md5('password'));

$sms = new Sms();
$sms->setReceiver('123123123');
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
    echo "Error status code: " . $response->getStatus();
}

```

Following code is an example how to check account ballance. 

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use PromoSMS\Api\Client;
use PromoSMS\Api\Sms\Sms;

$client = new Client('login@email.com', md5('password'));
echo "Current account balance is: " . $client->balance()->getAmount() / 100 . "\n";
```

###TODO

* Add MaxSMS support 
* Add FasterSMS support 
* Add feature to check how many sms will be sent for text message content. 
