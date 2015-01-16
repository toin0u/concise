<?php

namespace spec\Concise\Provider;

use Concise\Provider;
use PhpSpec\ObjectBehavior;

class ChainSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Provider\Chain');
    }

    function it_is_a_provider()
    {
        $this->shouldImplement('Concise\Provider');
    }

    function it_accepts_a_provider(Provider $provider)
    {
        $this->addProvider($provider);
        $this->getProviders()->shouldReturn([$provider]);
        $this->clearProviders();
        $this->getProviders()->shouldReturn([]);
    }

    function it_shortens_a_url(Provider $provider1, Provider $provider2)
    {
        $provider1->shorten('http://any.url')->willReturn('http://short.ly/1234');
        $provider2->shorten('http://short.ly/1234')->willReturn('http://short.er/1234');
        $this->addProvider($provider1);
        $this->addProvider($provider2);

        $this->shorten('http://any.url')->shouldReturn('http://short.er/1234');
    }

    function it_expands_a_url(Provider $provider1, Provider $provider2)
    {
        $provider1->expand('http://short.ly/1234')->willReturn('http://any.url');
        $provider2->expand('http://short.er/1234')->willReturn('http://short.ly/1234');
        $this->addProvider($provider1);
        $this->addProvider($provider2);

        $this->expand('http://short.er/1234')->shouldReturn('http://any.url');
    }
}
