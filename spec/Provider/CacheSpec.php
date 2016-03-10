<?php

namespace spec\Concise\Provider;

use Concise\Provider;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;
use PhpSpec\ObjectBehavior;

class CacheSpec extends ObjectBehavior
{
    function let(Provider $provider, CacheItemPoolInterface $pool)
    {
        $this->beConstructedWith($provider, $pool);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Provider\Cache');
    }

    function it_is_a_provider()
    {
        $this->shouldImplement('Concise\Provider');
    }

    function it_shortens_a_url(Provider $provider, CacheItemPoolInterface $pool, CacheItemInterface $item)
    {
        $item->isHit()->willReturn(false);
        $item->get()->willReturn(null);
        $item->set('http://short.ly/1234')->shouldBeCalled();
        $pool->getItem('shorten.'.md5('http://any.url'))->willReturn($item);
        $provider->shorten('http://any.url')->willReturn('http://short.ly/1234');

        $this->shorten('http://any.url')->shouldReturn('http://short.ly/1234');
    }

    function it_shortens_a_url_from_cache(CacheItemPoolInterface $pool, CacheItemInterface $item)
    {
        $item->isHit()->willReturn(true);
        $item->get()->willReturn('http://short.ly/1234');
        $pool->getItem('shorten.'.md5('http://any.url'))->willReturn($item);

        $this->shorten('http://any.url')->shouldReturn('http://short.ly/1234');
    }

    function it_expands_a_url(Provider $provider, CacheItemPoolInterface $pool, CacheItemInterface $item)
    {
        $item->isHit()->willReturn(false);
        $item->get()->willReturn(null);
        $item->set('http://any.url')->shouldBeCalled();
        $pool->getItem('expand.'.md5('http://short.ly/1234'))->willReturn($item);
        $provider->expand('http://short.ly/1234')->willReturn('http://any.url');

        $this->expand('http://short.ly/1234')->shouldReturn('http://any.url');
    }

    function it_expandss_a_url_from_cache(CacheItemPoolInterface $pool, CacheItemInterface $item)
    {
        $item->isHit()->willReturn(true);
        $item->get()->willReturn('http://any.url');
        $pool->getItem('expand.'.md5('http://short.ly/1234'))->willReturn($item);

        $this->expand('http://short.ly/1234')->shouldReturn('http://any.url');
    }
}
