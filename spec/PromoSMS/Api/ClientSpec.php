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
     * @param \PromoSMS\Api\Sms\EkoSms $sms
     */
    function it_sends_valid_eco_sms($client, $request, $response, $sms)
    {
        $sms->getType()->shouldBeCalled()->willReturn('sms');
        $sms->getMessage()->shouldBeCalled()->willReturn('test message');
        $sms->getReceiversCount()->shouldBeCalled()->willReturn(1);
        $sms->getReceivers()->shouldBeCalled()->willReturn(array(
            '111111111',
            '222222222'
        ));

        $response->getBody(true)->shouldBeCalled();

        $client->post('https://api.promosms.pl/send.php', array(), array(
            'query' => array(
                'login' => 'api@example.com',
                'password' => md5('password'),
                'to' => '111111111,222222222',
                'msg' => 'test message',
                'type' => 'sms'
            )
        ))->shouldBeCalled()->willReturn($request);

        $this->send($sms);
    }

    /**
     * @param \PromoSMS\Api\Sms\SmsInterface $sms
     */
    function it_throws_exception_when_sending_sms_without_receivers($sms)
    {
        $sms->getReceiversCount()->shouldBeCalled()->willReturn(0);

        $this->shouldThrow(new \InvalidArgumentException("Cant send sms with empty receivers list"))->during('send', array($sms));
    }

    /**
     * @param \PromoSMS\Api\Sms\SmsInterface $sms
     */
    function it_throws_exception_when_sending_sms_without_message($sms)
    {
        $sms->getReceiversCount()->shouldBeCalled()->willReturn(1);
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
        $sms->getReceiversCount()->shouldBeCalled()->willReturn(1);
        $sms->getMessage()->shouldBeCalled()->willReturn('');
        $this->shouldThrow(new \InvalidArgumentException("Cant send sms with empty message"))->during('send', array($sms));
    }
}
