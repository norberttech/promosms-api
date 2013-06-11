<?php

namespace PromoSMS\Api\Sms;

/**
 * Class SmsInterface
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
interface SmsInterface
{
    /**
     * @return null|string
     */
    public function getMessage();

    /**
     * @return array
     */
    public function getReceivers();

    /**
     * @param string $number
     * @return bool
     */
    public function addReceiver($number);

    /**
     * @return int
     */
    public function getReceiversCount();

    /**
     * @return bool
     */
    public function isSingle();

    /**
     * @param bool $single
     * @return \PromoSMS\Api\Sms\SmsInterface
     */
    public function setSingle($single = true);

    /**
     * @return string
     */
    function getType();
}