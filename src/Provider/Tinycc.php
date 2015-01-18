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

use Ivory\HttpAdapter\HttpAdapterInterface;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Tinycc extends HttpAdapterAware
{
    /**
     * @var string
     */
    const ENDPOINT = 'http://tiny.cc';

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var array
     */
    protected $defaultParams = [
        'c'       => 'rest_api',
        'version' => '2.0.3',
        'format'  => 'json',
    ];

    /**
     * @param HttpAdapterInterface $adapter
     * @param string               $login
     * @param string               $apiKey
     */
    public function __construct(HttpAdapterInterface $adapter, $login, $apiKey)
    {
        parent::__construct($adapter);

        $this->defaultParams['login'] = $this->login = $login;
        $this->defaultParams['apiKey'] = $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        $params = array_merge($this->defaultParams, [
            'm'       => 'shorten',
            'longUrl' => trim($url),
        ]);

        $url = sprintf('%s?%s', self::ENDPOINT, http_build_query($params));

        $response = $this->adapter->get($url);
        $response = json_decode($response->getBody());

        return $response->results->short_url;
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        $params = array_merge($this->defaultParams, [
            'm'       => 'expand',
            'shortUrl' => trim($url),
        ]);

        $url = sprintf('%s?%s', self::ENDPOINT, http_build_query($params));

        $response = $this->adapter->get($url);
        $response = json_decode($response->getBody());

        return $response->results->longUrl;
    }
}
