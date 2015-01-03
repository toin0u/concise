<?php

namespace spec\Concise\Provider;

use Concise\Provider;
use Stash\Interfaces\PoolInterface;
use Stash\Interfaces\ItemInterface;
use PhpSpec\ObjectBehavior;

class CacheSpec extends ObjectBehavior
{
    function let(Provider $provider, PoolInterface $pool)
    {
        $this->beConstructedWith($provider, $pool);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Provider\Cache');
        $this->shouldHaveType('Concise\Provider');
    }

    function it_should_allow_to_shorten_a_url(PoolInterface $pool, ItemInterface $item)
    {
        $item->isMiss()->willReturn(false);
        $item->get()->willReturn('http://short.ly/1234');
        $pool->getItem(md5('http://any.url'))->willReturn($item);

        $this->shorten('http://any.url')->shouldReturn('http://short.ly/1234');
    }

    function it_should_allow_to_expand_a_url(Provider $provider, PoolInterface $pool, ItemInterface $item)
    {
        $item->isMiss()->willReturn(true);
        $item->set('http://any.url')->shouldBeCalled();
        $pool->getItem(md5('http://short.ly/1234'))->willReturn($item);
        $provider->expand('http://short.ly/1234')->willReturn('http://any.url');

        $this->expand('http://short.ly/1234')->shouldReturn('http://any.url');
    }
}
