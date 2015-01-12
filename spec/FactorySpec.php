<?php

namespace spec\Concise;

use PhpSpec\ObjectBehavior;

class FactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Factory');
    }

    function it_creates_a_concise_instance()
    {
        $this->create('google')->shouldHaveType('Concise\Concise');
    }
}
