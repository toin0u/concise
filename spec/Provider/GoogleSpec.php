<?php

namespace spec\Concise\Provider;

use Ivory\HttpAdapter\HttpAdapterInterface;
use Psr\Http\Message\IncomingResponseInterface as Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GoogleSpec extends ObjectBehavior
{
    function let(HttpAdapterInterface $adapter)
    {
        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Provider\Google');
        $this->shouldImplement('Concise\Provider');
    }

    function it_should_allow_to_shorten_a_url(HttpAdapterInterface $adapter, Response $response)
    {
        $response->getBody()->willReturn('{"id": "http://goo.gl/shortened"}');
        $adapter->post(Argument::type('string'), Argument::type('array'), Argument::type('string'))->willReturn($response);

        $this->shorten('http://any.url')->shouldReturn("http://goo.gl/shortened");
    }

    function it_should_allow_to_expand_a_url(HttpAdapterInterface $adapter, Response $response)
    {
        $response->getBody()->willReturn('{"longUrl": "http://any.url"}');
        $adapter->get(Argument::type('string'), Argument::type('array'))->willReturn($response);

        $this->expand('http://goo.gl/shortened')->shouldReturn("http://any.url");
    }
}
