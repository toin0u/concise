<?php

/*
* This file is part of the concise project.
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
interface Adapter
{
    /**
     * @param  string           $path
     * @param  array            $headers (optional).
     * @throws RuntimeException
     * @return string
     */
    public function get($path, array $headers = array());

    /**
     * @param  string           $path
     * @param  string           $body    (optional).
     * @param  array            $headers (optional).
     * @throws RuntimeException
     * @return string
     */
    public function post($path, $body = null, array $headers = array());
}
