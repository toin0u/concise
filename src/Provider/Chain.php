<?php

namespace Concise\Provider;

use Concise\Provider;

/**
 * Shorten URL with multiple Providers
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Chain implements Provider
{
    /**
     * @var Provider[]
     */
    protected $providers = [];

    /**
     * Adds a provider to the chain
     *
     * @param Provider $provider
     */
    public function addProvider(Provider $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * Returns the providers in the chain
     *
     * @return Provider[]
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Removes all providers from the chain
     */
    public function clearProviders()
    {
        $this->providers = [];
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        foreach ($this->providers as $provider) {
            $url = $provider->shorten($url);
        }

        return $url;
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        foreach (array_reverse($this->providers) as $provider) {
            $url = $provider->expand($url);
        }

        return $url;
    }
}
