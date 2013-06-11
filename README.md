#Fully object oriented api for PromoSMS.pl service

Api is under development and you can't use it or even install by composer.
Following code is example how you will be able to use it after release.

```
use PromoSMS\Api\Client;
use PromoSMS\Api\Sms\EkoSms;


$client = new Client('email_login@domain.com', 'password');

$sms = EkoSms();
$sms->addReceiver('123456789');
$sms->setMessage('SMS Message');

$response = $client->send($sms);

if ($response->isValid()) {
    // dump ids of sent messages
    var_dump($response->getIds();
} else {
    echo $response->getErrorMessage();
}
```