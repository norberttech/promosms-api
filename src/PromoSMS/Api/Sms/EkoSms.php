<?php

namespace PromoSMS\Api\Sms;

class EkoSms extends AbstractSms
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'sms';
    }
}