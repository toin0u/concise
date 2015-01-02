<?php

namespace spec\Concise;

use Concise\Provider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
}
