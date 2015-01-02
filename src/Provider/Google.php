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

use Concise\Adapter;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Google extends \Concise\Provider
{
    /**
     * @var string
     */
    const ENDPOINT = 'https://www.googleapis.com/urlshortener/v1/url';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var array
     */
    protected $header = array(
        'Content-Type' => 'application/json'
    );

    /**
     * @param Adapter      $adapter
     * @param string|null  $apiKey
     */
    public function __construct(Adapter $adapter, $apiKey = null)
    {
        parent::__construct($adapter);

        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        $body = json_encode(array(
            'key'     => $this->apiKey,
            'longUrl' => $url,
        ));

        $response = $this->adapter->post(self::ENDPOINT, $body, $this->header);
        $response = json_decode($response);

        return $response->id;
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        $url = sprintf('%s?%s', self::ENDPOINT, http_build_query(array(
            'key'      => $this->apiKey,
            'shortUrl' => $url,
        )));

        $response = $this->adapter->get($url, $this->header);
        $response = json_decode($response);

        return $response->longUrl;
    }
}
