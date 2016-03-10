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
class Tinycc implements Provider
{
    /**
     * @var string
     */
    const ENDPOINT = 'http://tiny.cc';

    /**
     * @var array
     */
    private $params = [
        'c'       => 'rest_api',
        'version' => '2.0.3',
        'format'  => 'json',
    ];

    /**
     * @param string         $login
     * @param string         $apiKey
     * @param HttpClient     $httpClient
     * @param RequestFactory $requestFactory
     */
    public function __construct($login, $apiKey, HttpClient $httpClient, RequestFactory $requestFactory)
    {
        $this->params['login'] =  $login;
        $this->params['apiKey'] = $apiKey;

        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        $params = array_merge($this->params, [
            'm'       => 'shorten',
            'longUrl' => trim($url),
        ]);

        $url = sprintf('%s?%s', self::ENDPOINT, http_build_query($params));

        $request = $this->requestFactory->createRequest('GET', $url);

        $response = $this->httpClient->sendRequest($request);

        $response = json_decode((string) $response->getBody());

        return $response->results->short_url;
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        $params = array_merge($this->params, [
            'm'       => 'expand',
            'shortUrl' => trim($url),
        ]);

        $url = sprintf('%s?%s', self::ENDPOINT, http_build_query($params));

        $request = $this->requestFactory->createRequest('GET', $url);

        $response = $this->httpClient->sendRequest($request);

        $response = json_decode((string) $response->getBody());

        return $response->results->longUrl;
    }
}
