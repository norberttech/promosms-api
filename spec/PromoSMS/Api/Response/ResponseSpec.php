<?php

namespace spec\PromoSMS\Api\Response;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Argument::type('string'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PromoSMS\Api\Response\Response');
    }

    function it_return_response_status_code_id_and_number()
    {
        $this->beConstructedWith('<?xml version="1.0" encoding="UTF-8" ?><message><sms><number>48123123123</number><smsid>1b4138337c8b55c3736a32624b23c3328029d50f</smsid><status>001</status><description>Wyslano prawidlowo</description></sms></message>');

        $this->getStatus()->shouldReturn('001');
        $this->getId()->shouldReturn('1b4138337c8b55c3736a32624b23c3328029d50f');
        $this->getNumber()->shouldReturn('48123123123');
    }

    function it_is_not_valid_for_invalid_response_text()
    {
        $this->beConstructedWith('This is not a valid response');

        $this->isValid()->shouldReturn(false);
    }

    function it_is_not_valid_when_response_different_than_001()
    {
        $this->beConstructedWith('<?xml version="1.0" encoding="UTF-8" ?><message><sms><number></number><smsid></smsid><status>021</status><description>Zly login lub haslo</description></sms></message>');

        $this->isValid()->shouldReturn(false);
    }
}
