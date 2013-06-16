<?php

namespace PromoSMS\Api\Response;

/**
 * Class Balance
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
class Balance
{
    /**
     * @var string
     */
    protected $responseText;

    /**
     * @var int|null
     */
    protected $amount;

    /**
     * @param $responseText
     */
    public function __construct($responseText)
    {
        $this->responseText = $responseText;
        $this->parseResponseText();
    }

    /**
     *  Get account amount.
     *
     *  @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Parse responseText. If its invalid function is stopped and valid field value is changed to to false
     */
    protected function parseResponseText()
    {
        if (!empty($this->responseText)) {
            try {
                $response = new \SimpleXMLElement($this->responseText);

                if (isset($response->amount)) {
                    $this->amount = (int) $response->amount;
                }

            } catch (\Exception $e) {}
        }
    }
}