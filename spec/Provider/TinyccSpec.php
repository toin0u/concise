<?php

namespace spec\Concise\Provider;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use PhpSpec\ObjectBehavior;

class TinyccSpec extends ObjectBehavior
{
    private $params = [
        'c'       => 'rest_api',
        'version' => '2.0.3',
        'format'  => 'json',
        'login'   => 'login',
        'apiKey'  => 'apiKey',
    ];

    function let(HttpClient $httpClient, RequestFactory $requestFactory)
    {
        $this->beConstructedWith('login', 'apiKey', $httpClient, $requestFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Provider\Tinycc');
    }

    function it_is_a_provider()
    {
        $this->shouldImplement('Concise\Provider');
    }

    function it_shortens_a_url(
        RequestFactory $requestFactory,
        RequestInterface $request,
        HttpClient $httpClient,
        ResponseInterface $response,
        StreamInterface $body
    ) {
        $params = array_merge($this->params, [
            'm' => 'shorten',
            'longUrl' => 'http://any.url',
        ]);
        $requestFactory
            ->createRequest(
                'GET',
                sprintf('http://tiny.cc?%s', http_build_query($params))
            )
            ->willReturn($request);
        ;

        $httpClient->sendRequest($request)->willReturn($response);
        $response->getBody()->willReturn($body);
        $body->__toString()->willReturn('{"results": {"short_url": "http://tiny.cc/shortened"}}');

        $this->shorten('http://any.url')->shouldReturn("http://tiny.cc/shortened");
    }

    function it_expands_a_url(
        RequestFactory $requestFactory,
        RequestInterface $request,
        HttpClient $httpClient,
        ResponseInterface $response,
        StreamInterface $body
    ) {
        $params = array_merge($this->params, [
            'm' => 'expand',
            'shortUrl' => 'http://tiny.cc/shortened',
        ]);

        $requestFactory
            ->createRequest(
                'GET',
                sprintf('http://tiny.cc?%s', http_build_query($params))
            )
            ->willReturn($request);
        ;

        $httpClient->sendRequest($request)->willReturn($response);
        $response->getBody()->willReturn($body);
        $body->__toString()->willReturn('{"results": {"longUrl": "http://any.url"}}');

        $this->expand('http://tiny.cc/shortened')->shouldReturn("http://any.url");
    }
}
