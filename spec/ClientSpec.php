<?php

namespace spec\Matthewbdaly\TransportApi;

use Matthewbdaly\TransportApi\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }
}
