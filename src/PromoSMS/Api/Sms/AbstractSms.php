<?php

namespace PromoSMS\Api\Sms;

abstract class AbstractSms implements SmsInterface
{
    /**
     * @var string|null
     */
    protected $message;

    /**
     * @var array
     */
    protected $receivers;

    /**
     * @var bool
     */
    protected $single;


    public function __construct()
    {
        $this->single = true;
        $this->receivers = array();
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function getReceivers()
    {
        return $this->receivers;
    }

    /**
     * {@inheritdoc}
     */
    public function addReceiver($number)
    {
        if (!in_array($number, $this->receivers)) {
            $this->receivers[] = $number;
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiversCount()
    {
        return count($this->receivers);
    }

    /**
     * {@inheritdoc}
     */
    public function setSingle($single = true)
    {
        $this->single = $single;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSingle()
    {
        return $this->single;
    }
}