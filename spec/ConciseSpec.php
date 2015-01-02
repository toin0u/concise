<?php

namespace spec\Concise;

use Concise\Provider;
use PhpSpec\ObjectBehavior;

class ConciseSpec extends ObjectBehavior
{
    function let(Provider $provider)
    {
        $this->beConstructedWith($provider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Concise');
    }

    function it_should_allow_to_shorten_a_url(Provider $provider)
    {
        $provider->shorten('http://any.url')->willReturn("http://goo.gl/shortened");

        $this->shorten('http://any.url')->shouldReturn("http://goo.gl/shortened");
    }

    function it_should_allow_to_expand_a_url(Provider $provider)
    {
        $provider->expand('http://goo.gl/shortened')->willReturn("http://any.url");

        $this->expand('http://goo.gl/shortened')->shouldReturn("http://any.url");
    }
}
