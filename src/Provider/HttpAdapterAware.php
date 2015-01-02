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
use Ivory\HttpAdapter\HttpAdapterInterface;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class HttpAdapterAware implements Provider
{
    /**
     * @var HttpAdapterInterface
     */
    protected $adapter;

    /**
     * @param HttpAdapterInterface $adapter
     */
    public function __construct(HttpAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }
}
