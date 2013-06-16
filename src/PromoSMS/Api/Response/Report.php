<?php

namespace PromoSMS\Api\Response;

/**
 * Class Report
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
class Report
{
    /**
     * @var string
     */
    protected $responseText;

    /**
     * @var string|null
     */
    protected $number;

    /**
     * @var int|null
     */
    protected $type;

    /**
     * @var \DateTime
     */
    protected $time;

    /**
     * @var string|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $status;

    /**
     * @var boolean
     */
    protected $received;

    /**
     * @param string $responseText
     */
    public function __construct($responseText)
    {
        $this->received = false;
        $this->responseText = $responseText;
        $this->parseResponseText();
    }

    /**
     * @return null|string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return int|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \DateTime|null
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Full status list is available here: http://dev.promosms.pl/sms-api/HTTP_SSL_API#Odbi.C3.B3r_raport.C3.B3w_dostarczenia_-_opis_parametr.C3.B3w_dodatkowych
     *
     * @return null|string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Return true if message was successfully delivered.
     *
     * @return bool
     */
    public function isReceived()
    {
        return $this->received;
    }

    /**
     * Parse responseText
     */
    protected function parseResponseText()
    {
        if (!empty($this->responseText)) {
            try {
                $response = new \SimpleXMLElement($this->responseText);

                if (isset($response->report)) {
                    if (!empty($response->report->number)) {
                        $this->number = (string) $response->report->number;
                    }

                    if (!empty($response->report->type)) {
                        $this->type = (int) $response->report->type;
                    }

                    if (!empty($response->report->time)) {
                        $dateTime = new \DateTime();
                        $this->time = $dateTime->createFromFormat('U', (int) $response->report->time);
                    }

                    if (!empty($response->report->smsid)) {
                        $this->id = (string) $response->report->smsid;
                    }

                    if (!empty($response->report->status)) {
                        $this->status = (string) $response->report->status;
                    }
                }

            } catch (\Exception $e) {}
        }

        if ($this->status === '001') {
            $this->received = true;
        }
    }
}