<?php

namespace spec\Matthewbdaly\TransportApi;

use Matthewbdaly\TransportApi\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ClientSpec extends ObjectBehavior
{
    function let (HttpClient $client, MessageFactory $messageFactory)
    {
        $appId = "Foo";
        $key = "Bar";
        $this->beConstructedWith($appId, $key, $client, $messageFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement('Matthewbdaly\TransportApi\Contracts\Client');
    }

    function it_can_get_departures(HttpClient $client, MessageFactory $messageFactory, RequestInterface $request, ResponseInterface $response)
    {
        $appId = "Foo";
        $key = "Bar";
        $this->beConstructedWith($appId, $key, $client, $messageFactory);
        $url = "http://transportapi.com/v3/uk/train/station/NRW/live.json?app_id=$appId&app_key=$key&destination=LST&train_status=passenger";
        $messageFactory->createRequest('GET', $url)->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $this->getDepartures('NRW', 'LST')->shouldReturn($response);
    }
}
