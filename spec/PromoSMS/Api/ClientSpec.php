<?php

namespace spec\PromoSMS\Api;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientSpec extends ObjectBehavior
{
    /**
     * @param \Guzzle\Http\Client $client
     * @param \Guzzle\Http\Message\Request $request
     * @param \Guzzle\Http\Message\Response $response
     */
    function let($client, $request, $response)
    {
        $this->beConstructedWith('api@example.com', 'password', $client);

        $request->send()->willReturn($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PromoSMS\Api\Client');
    }

    function it_has_default_api_url()
    {
        $this->getApiUrl()->shouldReturn('https://api.promosms.pl/');
    }

    function it_has_valid_api_url_after_setting_it()
    {
        $this->setApiUrl('http://this.is.new.url.com')->shouldReturn($this);
        $this->getApiUrl()->shouldReturn('http://this.is.new.url.com');
    }

    /**
     * @param \Guzzle\Http\Client $client
     * @param \Guzzle\Http\Message\Request $request
     * @param \Guzzle\Http\Message\Response $response
     * @param \PromoSMS\Api\Sms\Sms $sms
     */
    function it_send_eco_sms($client, $request, $response, $sms)
    {
        $this->buildDefaultSms($sms);
        $response->getBody(true)->shouldBeCalled();

        $client->post('https://api.promosms.pl/send.php', array(), array(
            'login' => 'api@example.com',
            'pass' => 'password',
            'to' => '111111111',
            'message' => 'test message',
            'type' => 'sms'
        ))->shouldBeCalled()->willReturn($request);

        $this->send($sms);
    }

    /**
     * @param \Guzzle\Http\Client $client
     * @param \Guzzle\Http\Message\Request $request
     * @param \Guzzle\Http\Message\Response $response
     * @param \PromoSMS\Api\Sms\Sms $sms
     */
    function it_send_eco_sms_with_disabled_single_constraint($client, $request, $response, $sms)
    {
        $this->buildDefaultSms($sms);
        $sms->isSingle()->willReturn(false);

        $response->getBody(true)->shouldBeCalled();

        $client->post('https://api.promosms.pl/send.php', array(), array(
            'login' => 'api@example.com',
            'pass' => 'password',
            'to' => '111111111',
            'message' => 'test message',
            'type' => 'sms',
            'single' => 0
        ))->shouldBeCalled()->willReturn($request);

        $this->send($sms);
    }

    /**
     * @param \Guzzle\Http\Client $client
     * @param \Guzzle\Http\Message\Request $request
     * @param \Guzzle\Http\Message\Response $response
     * @param \PromoSMS\Api\Sms\Sms $sms
     */
    function it_send_eco_sms_with_pl_turned_on($client, $request, $response, $sms)
    {
        $this->buildDefaultSms($sms);
        $sms->isPl()->willReturn(true);

        $response->getBody(true)->shouldBeCalled();

        $client->post('https://api.promosms.pl/send.php', array(), array(
            'login' => 'api@example.com',
            'pass' => 'password',
            'to' => '111111111',
            'message' => 'test message',
            'type' => 'sms',
            'pl' => 1
        ))->shouldBeCalled()->willReturn($request);

        $this->send($sms);
    }

    /**
     * @param \Guzzle\Http\Client $client
     * @param \Guzzle\Http\Message\Request $request
     * @param \Guzzle\Http\Message\Response $response
     * @param \PromoSMS\Api\Sms\Sms $sms
     */
    function it_send_eco_sms_with_time($client, $request, $response, $sms)
    {
        $this->buildDefaultSms($sms);
        $sms->hasTime()->willReturn(true);
        $sms->getTime()->willReturn(61371296027);

        $response->getBody(true)->shouldBeCalled();

        $client->post('https://api.promosms.pl/send.php', array(), array(
            'login' => 'api@example.com',
            'pass' => 'password',
            'to' => '111111111',
            'message' => 'test message',
            'type' => 'sms',
            'time' => 61371296027
        ))->shouldBeCalled()->willReturn($request);

        $this->send($sms);
    }

    /**
     * @param \PromoSMS\Api\Sms\SmsInterface $sms
     */
    function it_throws_exception_when_sending_sms_without_receivers($sms)
    {
        $sms->getReceiver()->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new \InvalidArgumentException("Cant send sms with empty receiver"))->during('send', array($sms));
    }

    /**
     * @param \PromoSMS\Api\Sms\SmsInterface $sms
     */
    function it_throws_exception_when_sending_sms_without_message($sms)
    {
        $sms->getReceiver()->shouldBeCalled()->willReturn('111111111');
        $sms->getMessage()->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(new \InvalidArgumentException("Cant send sms with empty message"))->during('send', array($sms));

        $sms->getMessage()->shouldBeCalled()->willReturn('');
        $this->shouldThrow(new \InvalidArgumentException("Cant send sms with empty message"))->during('send', array($sms));
    }

    /**
     * @param \PromoSMS\Api\Sms\SmsInterface $sms
     */
    function it_throws_exception_when_sending_sms_with_empty_message($sms)
    {
        $sms->getReceiver()->shouldBeCalled()->willReturn('111111111');
        $sms->getMessage()->shouldBeCalled()->willReturn('');
        $this->shouldThrow(new \InvalidArgumentException("Cant send sms with empty message"))->during('send', array($sms));
    }

    /**
     * @param \PromoSMS\Api\Sms\Sms $sms
     */
    protected function buildDefaultSms($sms)
    {
        $sms->hasTime()->shouldBeCalled()->willReturn(false);
        $sms->isPl()->shouldBeCalled()->willReturn(false);
        $sms->isSingle()->shouldBeCalled()->willReturn(true);
        $sms->getType()->shouldBeCalled()->willReturn('sms');
        $sms->getMessage()->shouldBeCalled()->willReturn('test message');
        $sms->getReceiver()->shouldBeCalled()->willReturn('111111111');
    }
}
