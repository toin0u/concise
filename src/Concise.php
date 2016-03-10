<?php

namespace Concise;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Concise
{
    /**
     * Version
     */
    const VERSION = '0.2-dev';

    /**
     * @var Provider
     */
    protected $provider;

    /**
     * @param Provider $provider
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function shorten($url)
    {
        return $this->provider->shorten($url);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function expand($url)
    {
        return $this->provider->expand($url);
    }
}
