<?php

namespace spec\PromoSMS\Api\Sms;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EkoSmsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PromoSMS\Api\Sms\EkoSms');
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

    function it_has_empty_receivers_list_by_default()
    {
        $this->getReceivers()->shouldReturn(array());
    }

    function it_has_receiver_after_adding_him()
    {
        $this->addReceiver('1111111');

        $this->getReceivers()->shouldReturn(array('1111111'));
    }

    function it_cant_add_receiver_if_its_already_in_list()
    {
        $this->addReceiver('1111111')->shouldReturn(true);
        $this->addReceiver('1111111')->shouldReturn(false);
    }

    function it_return_valid_receivers_count()
    {
        $this->getReceiversCount()->shouldReturn(0);

        $this->addReceiver('1111111');

        $this->getReceiversCount()->shouldReturn(1);
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

    function it_is_single_after_setting_single_without_param()
    {
        $this->setSingle();
        $this->isSingle()->shouldReturn(true);
    }
}
