<?php

namespace Concise\Provider;

use Ivory\HttpAdapter\HttpAdapterInterface;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Bitly extends HttpAdapterAware
{
    /**
     * @var string
     */
    const ENDPOINT = 'https://api-ssl.bitly.com/v3';

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @param HttpAdapterInterface $adapter
     * @param string               $accessToken
     */
    public function __construct(HttpAdapterInterface $adapter, $accessToken)
    {
        parent::__construct($adapter);

        $this->accessToken = $accessToken;
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

        $response = $this->adapter->get($url);
        $response = json_decode($response->getBody());

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

        $response = $this->adapter->get($url);
        $response = json_decode($response->getBody());

        return $response->data->expand[0]->long_url;
    }
}
