<?php

namespace PromoSMS\Api\Response;

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
        preg_match('/^Status: ([0-9]{3}), Id: ([a-fA-F\d]+|), Number: ([0-9]+|)$/', $this->responseText, $statusMatches);

        if (isset($statusMatches[1])) {
            $this->status = $statusMatches[1];
        }

        if (isset($statusMatches[2]) && !empty($statusMatches[2])) {
            $this->id = $statusMatches[2];
        }

        if (isset($statusMatches[3]) && !empty($statusMatches[3])) {
            $this->number = $statusMatches[3];
        }

        if ($this->status === '001') {
            $this->valid = true;
        }
    }

}