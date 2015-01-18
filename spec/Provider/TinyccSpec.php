<?php

namespace spec\Concise\Provider;

use Ivory\HttpAdapter\HttpAdapterInterface;
use Psr\Http\Message\IncomingResponseInterface as Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TinyccSpec extends ObjectBehavior
{
    function let(HttpAdapterInterface $adapter)
    {
        $this->beConstructedWith($adapter, 'login', 'apiKey');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Provider\Tinycc');
    }

    function it_is_a_provider()
    {
        $this->shouldImplement('Concise\Provider');
    }

    function it_shortens_a_url(HttpAdapterInterface $adapter, Response $response)
    {
        $response->getBody()->willReturn('{"results": {"short_url": "http://tiny.cc/shortened"}}');
        $adapter->get(Argument::type('string'))->willReturn($response);

        $this->shorten('http://any.url')->shouldReturn("http://tiny.cc/shortened");
    }

    function it_expands_a_url(HttpAdapterInterface $adapter, Response $response)
    {
        $response->getBody()->willReturn('{"results": {"longUrl": "http://any.url"}}');
        $adapter->get(Argument::type('string'))->willReturn($response);

        $this->expand('http://tiny.cc/shortened')->shouldReturn("http://any.url");
    }
}
