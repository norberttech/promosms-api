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
        $this->beConstructedWith('Status: 001, Id: d2786e5abf5439f3f169215951da9f09b32b67b5, Number: 48123123123');

        $this->getStatus()->shouldReturn('001');
        $this->getId()->shouldReturn('d2786e5abf5439f3f169215951da9f09b32b67b5');
        $this->getNumber()->shouldReturn('48123123123');
    }

    function it_is_not_valid_for_invalid_response_text()
    {
        $this->beConstructedWith('This is not a valid response');

        $this->isValid()->shouldReturn(false);
    }

    function it_is_not_valid_when_response_different_than_001()
    {
        $this->beConstructedWith('Status: 021, Id: , Number: ');

        $this->isValid()->shouldReturn(false);
    }
}
