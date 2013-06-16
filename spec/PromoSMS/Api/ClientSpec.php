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
            'type' => 'sms',
            'return' => 'xml',
        ))->shouldBeCalled()->willReturn($request);

        $this->send($sms)->shouldReturnAnInstanceOf('PromoSMS\Api\Response\Response');
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
            'return' => 'xml',
            'single' => 0
        ))->shouldBeCalled()->willReturn($request);

        $this->send($sms)->shouldReturnAnInstanceOf('PromoSMS\Api\Response\Response');
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
            'return' => 'xml',
            'pl' => 1
        ))->shouldBeCalled()->willReturn($request);

        $this->send($sms)->shouldReturnAnInstanceOf('PromoSMS\Api\Response\Response');
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
            'return' => 'xml',
            'time' => 61371296027
        ))->shouldBeCalled()->willReturn($request);

        $this->send($sms)->shouldReturnAnInstanceOf('PromoSMS\Api\Response\Response');
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
     * @param \Guzzle\Http\Client $client
     * @param \Guzzle\Http\Message\Request $request
     * @param \Guzzle\Http\Message\Response $response
     */
    function it_gets_report_about_sms_delivery($client, $request, $response)
    {
        $response->getBody(true)->shouldBeCalled();

        $client->post('https://api.promosms.pl/getreports.php', array(), array(
            'smsid' => '3095dbfcb9273218857172b1e75e7cd5',
            'return' => 'xml',
        ))->shouldBeCalled()->willReturn($request);

        $this->report('3095dbfcb9273218857172b1e75e7cd5')->shouldReturnAnInstanceOf('PromoSMS\Api\Response\Report');
    }

    /**
     * @param \Guzzle\Http\Client $client
     * @param \Guzzle\Http\Message\Request $request
     * @param \Guzzle\Http\Message\Response $response
     */
    function it_gets_account_balance($client, $request, $response)
    {
        $response->getBody(true)->shouldBeCalled();
        $client->post('https://api.promosms.pl/checkbalance.php', array(), array(
            'login' => 'api@example.com',
            'pass' => 'password',
            'return' => 'xml'
        ))->shouldBeCalled()->willReturn($request);

        $this->balance()->shouldReturnAnInstanceOf('PromoSMS\Api\Response\Balance');
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
