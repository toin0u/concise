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
use Http\Client\HttpClient;
use Http\Message\RequestFactory;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Google implements Provider
{
    /**
     * @var string
     */
    const ENDPOINT = 'https://www.googleapis.com/urlshortener/v1/url';

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @var string|null
     */
    private $apiKey;

    /**
     * @param HttpClient     $httpClient
     * @param RequestFactory $requestFactory
     * @param string|null    $apiKey
     */
    public function __construct(HttpClient $httpClient, RequestFactory $requestFactory, $apiKey = null)
    {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
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

        $request = $this->requestFactory->createRequest('POST', self::ENDPOINT, $headers, $body);

        $response = $this->httpClient->sendRequest($request);

        $response = json_decode((string) $response->getBody());

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

        $request = $this->requestFactory->createRequest('GET', $url);

        $response = $this->httpClient->sendRequest($request);

        $response = json_decode((string) $response->getBody());

        return $response->longUrl;
    }
}
