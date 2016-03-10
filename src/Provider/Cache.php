<?php

/*
 * This file is part of the Concise package.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Concise\Provider;

use Concise\Provider;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Cache URLs
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Cache implements Provider
{
    /**
     * @var Provider
     */
    private $provider;

    /**
     * @var CacheItemPoolInterface
     */
    private $pool;

    /**
     * @param Provider $provider
     */
    public function __construct(Provider $provider, CacheItemPoolInterface $pool)
    {
        $this->provider = $provider;
        $this->pool = $pool;
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        $item = $this->pool->getItem('shorten.'.md5($url));

        $cachedUrl = $item->get();

        if (false === $item->isHit()) {
            $cachedUrl = $this->provider->shorten($url);

            $item->set($cachedUrl);
        }

        return $cachedUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        $item = $this->pool->getItem('expand.'.md5($url));

        $cachedUrl = $item->get();

        if (false === $item->isHit()) {
            $cachedUrl = $this->provider->expand($url);

            $item->set($cachedUrl);
        }

        return $cachedUrl;
    }
}
