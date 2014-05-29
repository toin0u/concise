<?php

namespace spec\Concise\Adapter;

use Guzzle\Http\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GuzzleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Adapter\Guzzle');
    }

    function it_accepts_custom_guzzle_client(Client $client)
    {
        $this->beConstructedWith($client);

        $this->shouldHaveType('Concise\Adapter\Guzzle');
    }

    function it_throws_RuntimeException_on_GET_request_if_the_given_url_is_malformed()
    {
        $this->shouldThrow('Concise\Exception\RuntimeException')->duringGet('foo');
    }

    function it_throws_RuntimeException_on_POST_request_if_the_given_url_is_malformed()
    {
        $this->shouldThrow('Concise\Exception\RuntimeException')->duringPost('foo');
    }
}
