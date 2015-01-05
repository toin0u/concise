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
