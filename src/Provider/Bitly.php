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
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Bitly implements Provider
{
    /**
     * @var string
     */
    const ENDPOINT = 'https://api-ssl.bitly.com/v3';

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @param string         $accessToken
     * @param HttpClient     $httpClient
     * @param RequestFactory $requestFactory
     */
    public function __construct($accessToken, HttpClient $httpClient, RequestFactory $requestFactory)
    {
        $this->accessToken = $accessToken;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        $url = sprintf('%s/shorten?%s', self::ENDPOINT, http_build_query([
            'access_token' => $this->accessToken,
            'longUrl'      => trim($url),
        ]));

        $request = $this->requestFactory->createRequest('GET', $url);

        $response = $this->httpClient->sendRequest($request);

        $response = json_decode((string) $response->getBody());

        return $response->data->url;
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        $url = sprintf('%s/expand?%s', self::ENDPOINT, http_build_query([
            'access_token' => $this->accessToken,
            'shortUrl'     => trim($url),
        ]));

        $request = $this->requestFactory->createRequest('GET', $url);

        $response = $this->httpClient->sendRequest($request);

        $response = json_decode((string) $response->getBody());

        return $response->data->expand[0]->long_url;
    }
}
