<?php

/*
* This file is part of the Concise package.
*
* (c) Antoine Corcy <contact@sbin.dk>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Concise;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Concise
{
    /**
     * Version
     */
    const VERSION = '0.1-dev';

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
