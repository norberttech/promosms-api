<?php

namespace spec\PromoSMS\Api\Response;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BalanceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Argument::type('string'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PromoSMS\Api\Response\Balance');
    }

    function it_return_amount()
    {
        $this->beConstructedWith('<?xml version="1.0" encoding="UTF-8" ?><balance><amount>1004</amount></balance>');

        $this->getAmount()->shouldReturn(1004);
    }
}
