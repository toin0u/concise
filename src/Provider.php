<?php

namespace Concise;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
interface Provider
{
    /**
     * @param string $url
     *
     * @return string
     */
    public function shorten($url);

    /**
     * @param string $url
     *
     * @return string
     */
    public function expand($url);
}
