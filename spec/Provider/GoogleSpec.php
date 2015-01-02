<?php

namespace spec\Concise\Provider;

use Concise\Adapter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GoogleSpec extends ObjectBehavior
{
    function let(Adapter $adapter)
    {
        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Provider\Google');
    }
}
