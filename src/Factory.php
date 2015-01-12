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

use Ivory\HttpAdapter\HttpAdapterFactory;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Factory
{
    /**
     * List of available providers
     *
     * @var array
     */
    protected static $providers = array(
        'google' => array(
            'provider' => 'Concise\Provider\Google'
        ),
    );

    /**
     * Creates a new Concise instance
     *
     * @param string $name Provider name
     *
     * @return Concise
     */
    public static function create($name)
    {
        if (!isset(static::$providers[$name])) {
            throw new \InvalidArgumentException(sprintf('Provider "%s" does not exists', $name));
        }

        $httpAdapter = HttpAdapterFactory::guess();

        $provider = new static::$providers[$name]['provider']($httpAdapter);

        return new Concise($provider);
    }
}
