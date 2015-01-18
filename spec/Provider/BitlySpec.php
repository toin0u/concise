<?php

namespace spec\Concise\Provider;

use Ivory\HttpAdapter\HttpAdapterInterface;
use Psr\Http\Message\IncomingResponseInterface as Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BitlySpec extends ObjectBehavior
{
    function let(HttpAdapterInterface $adapter)
    {
        $this->beConstructedWith($adapter, 'access_token');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Provider\Bitly');
    }

    function it_is_a_provider()
    {
        $this->shouldImplement('Concise\Provider');
    }

    function it_shortens_a_url(HttpAdapterInterface $adapter, Response $response)
    {
        $response->getBody()->willReturn('{"data": {"url": "http://bit.ly/shortened"}}');
        $adapter->get(Argument::type('string'))->willReturn($response);

        $this->shorten('http://any.url')->shouldReturn("http://bit.ly/shortened");
    }

    function it_expands_a_url(HttpAdapterInterface $adapter, Response $response)
    {
        $response->getBody()->willReturn('{"data": {"expand": [{"long_url": "http://any.url"}]}}');
        $adapter->get(Argument::type('string'))->willReturn($response);

        $this->expand('http://bit.ly/shortened')->shouldReturn("http://any.url");
    }
}
