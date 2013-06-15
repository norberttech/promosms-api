<?php

namespace spec\PromoSMS\Api\Sms;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SmsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PromoSMS\Api\Sms\Sms');
        $this->shouldBeAnInstanceOf('PromoSMS\Api\Sms\SmsInterface');
    }

    function it_has_valid_type()
    {
        $this->getType()->shouldReturn('sms');
    }

    function it_should_be_instance_of_sms()
    {
        $this->shouldImplement('PromoSMS\Api\Sms\SmsInterface');
    }

    function it_has_null_message_by_default()
    {
        $this->getMessage()->shouldReturn(null);
    }

    function it_has_null_receiver_by_default()
    {
        $this->getReceiver()->shouldReturn(null);
    }

    function it_has_receiver_after_setting_him()
    {
        $this->setReceiver('1111111');

        $this->getReceiver()->shouldReturn('1111111');
    }

    function it_has_message_after_setting_it()
    {
        $this->setMessage('message');

        $this->getMessage()->shouldReturn('message');
    }

    function it_is_single_by_default()
    {
        $this->isSingle()->shouldReturn(true);
    }

    function it_is_not_single_after_change()
    {
        $this->setSingle(false);
        $this->isSingle()->shouldReturn(false);
    }

    function it_is_single_after_calling_single_without_param()
    {
        $this->setSingle();
        $this->isSingle()->shouldReturn(true);
    }

    function it_is_not_pl_by_default()
    {
        $this->isPl()->shouldReturn(false);
    }

    function it_is_pl_after_calling_set_pl()
    {
        $this->setPl();

        $this->isPl()->shouldReturn(true);
    }

    function it_does_not_have_time_by_default()
    {
        $this->hasTime()->shouldReturn(false);
    }

    function it_throws_exception_when_setting_time_in_past()
    {
        $time = new \DateTime();
        $this->shouldThrow(new \InvalidArgumentException("Cant set past time as a send time"))->during('setTime', array($time));
    }

    function it_has_time_after_setting_it()
    {
        $time = new \DateTime();
        $time->add(new \DateInterval('P1D'));
        $this->setTime($time);

        $this->getTime()->shouldReturn($time->getTimestamp());
    }
}
