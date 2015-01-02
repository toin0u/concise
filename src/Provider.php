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
abstract class Provider
{
    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    abstract public function shorten($url);

    /**
     * @param string $url
     *
     * @return string
     */
    abstract public function expand($url);
}
