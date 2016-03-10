<?php

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
