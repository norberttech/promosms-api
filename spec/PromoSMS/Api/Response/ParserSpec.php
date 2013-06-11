<?php

namespace spec\PromoSMS\Api\Response;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PromoSMS\Api\Response\Parser');
    }

    function it_should_parse_valid_response()
    {
        $this->parse('Status: 001, Id: ff0b22f07a29289bd0cf630985f405b774aeac9f, Number: 0048518187989');
    }
}
