<?php

namespace PromoSMS\Api\Response;

/**
 * Class Response
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
class Response
{
    /**
     * @var string
     */
    private $responseText;

    /**
     * @var boolean
     */
    private $valid;

    /**
     * @var null|string
     */
    private $status;

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $number;

    /**
     * @param string $responseText
     */
    public function __construct($responseText)
    {
        $this->valid = false;
        $this->responseText = $responseText;
        $this->parseResponseText();
    }

    /**
     * @return null|string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * Parse responseText. If its invalid function is stopped and valid field value is changed to to false
     */
    protected function parseResponseText()
    {
        if (!empty($this->responseText)) {
            try {
                $response = new \SimpleXMLElement($this->responseText);

                if (isset($response->sms)) {
                    $this->status = (string) $response->sms->status;

                    if (!empty($response->sms->number)) {
                        $this->number = (string) $response->sms->number;
                    }

                    if (!empty($response->sms->smsid)) {
                        $this->id = (string) $response->sms->smsid;
                    }
                }

            } catch (\Exception $e) {}
        }

        if ($this->status === '001') {
            $this->valid = true;
        }
    }
}
