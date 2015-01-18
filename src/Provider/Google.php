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
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Google extends HttpAdapterAware
{
    /**
     * @var string
     */
    const ENDPOINT = 'https://www.googleapis.com/urlshortener/v1/url';

    /**
     * @var string|null
     */
    protected $apiKey;

    /**
     * @param HttpAdapterInterface $adapter
     * @param string|null          $apiKey
     */
    public function __construct(HttpAdapterInterface $adapter, $apiKey = null)
    {
        parent::__construct($adapter);

        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        $headers = ['Content-Type' => 'application/json'];

        $body = json_encode([
            'key'     => $this->apiKey,
            'longUrl' => $url,
        ]);

        $response = $this->adapter->post(self::ENDPOINT, $headers, $body);
        $response = json_decode($response->getBody());

        return $response->id;
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        $url = sprintf('%s?%s', self::ENDPOINT, http_build_query([
            'key'      => $this->apiKey,
            'shortUrl' => $url,
        ]));

        $response = $this->adapter->get($url);
        $response = json_decode($response->getBody());

        return $response->longUrl;
    }
}
