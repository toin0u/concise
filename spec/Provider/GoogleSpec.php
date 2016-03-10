<?php

namespace spec\Concise\Provider;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use PhpSpec\ObjectBehavior;

class GoogleSpec extends ObjectBehavior
{
    function let(HttpClient $httpClient, RequestFactory $requestFactory)
    {
        $this->beConstructedWith($httpClient, $requestFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Provider\Google');
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
        $requestFactory
            ->createRequest(
                'POST',
                'https://www.googleapis.com/urlshortener/v1/url',
                ['Content-Type' => 'application/json'],
                json_encode([
                    'key' => null,
                    'longUrl' => 'http://any.url',
                ])
            )
            ->willReturn($request);
        ;

        $httpClient->sendRequest($request)->willReturn($response);
        $response->getBody()->willReturn($body);
        $body->__toString()->willReturn('{"id": "http://goo.gl/shortened"}');

        $this->shorten('http://any.url')->shouldReturn("http://goo.gl/shortened");
    }

    function it_expands_a_url(
        RequestFactory $requestFactory,
        RequestInterface $request,
        HttpClient $httpClient,
        ResponseInterface $response,
        StreamInterface $body
    ) {
        $requestFactory
            ->createRequest(
                'GET',
                'https://www.googleapis.com/urlshortener/v1/url?shortUrl='.urlencode('http://goo.gl/shortened')
            )
            ->willReturn($request);
        ;

        $httpClient->sendRequest($request)->willReturn($response);
        $response->getBody()->willReturn($body);
        $body->__toString()->willReturn('{"longUrl": "http://any.url"}');

        $this->expand('http://goo.gl/shortened')->shouldReturn("http://any.url");
    }
}
