<?php

namespace Concise\Provider;

use Concise\Provider;
use Stash\Interfaces\PoolInterface;

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
    protected $provider;

    /**
     * @var PoolInterface
     */
    protected $pool;

    /**
     * @param Provider $provider
     */
    public function __construct(Provider $provider, PoolInterface $pool)
    {
        $this->provider = $provider;
        $this->pool = $pool;
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        return $this->transformUrl($url, 'shorten');
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        return $this->transformUrl($url, 'expand');
    }

    /**
     * Shorten or expand a URL checking it in the cache first
     *
     * @param string $url
     * @param string $transformation
     *
     * @return string
     */
    protected function transformUrl($url, $transformation)
    {
        $cachedUrl = $this->pool->getItem(md5($url));

        if ($cachedUrl->isMiss()) {
            $url = $this->provider->$transformation($url);

            $cachedUrl->set($url);
        } else {
            $url = $cachedUrl->get();
        }

        return $url;
    }
}
