<?php

namespace spec\PromoSMS\Api\Response;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReportSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Argument::type('string'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PromoSMS\Api\Response\Report');
    }

    function it_return_report_number_type_time_smsid_ownid_status()
    {
        $this->beConstructedWith('<?xml version="1.0" encoding="UTF-8" ?><reports><report><number>48123123123</number><type>1</type><time>1371385733</time><smsid>7ab423e2461c386c06128ceb51797603d0dd8d93</smsid><ownid></ownid><status>001</status><description>Odbior informacji o raporcie prawidlowy</description></report></reports>');

        $this->getNumber()->shouldReturn('48123123123');
        $this->getType()->shouldReturn(1);
        $this->getTime()->shouldReturnAnInstanceOf(new \DateTime());
        $this->getId()->shouldReturn('7ab423e2461c386c06128ceb51797603d0dd8d93');
        $this->getStatus()->shouldReturn('001');
    }

    function it_return_positive_sms_received_status()
    {
        $this->beConstructedWith('<?xml version="1.0" encoding="UTF-8" ?><reports><report><number>48123123123</number><type>1</type><time>1371385733</time><smsid>7ab423e2461c386c06128ceb51797603d0dd8d93</smsid><ownid></ownid><status>001</status><description>Odbior informacji o raporcie prawidlowy</description></report></reports>');

        $this->isReceived()->shouldReturn(true);
    }

    function it_return_negative_sms_received_status()
    {
        $this->beConstructedWith('<?xml version="1.0" encoding="UTF-8" ?><reports><report><number>48123123123</number><type>1</type><time>1371385733</time><smsid>7ab423e2461c386c06128ceb51797603d0dd8d93</smsid><ownid></ownid><status>000</status><description>Odbior informacji o raporcie prawidlowy</description></report></reports>');

        $this->isReceived()->shouldReturn(false);
    }
}
