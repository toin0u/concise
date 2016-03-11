<?php

namespace spec\Concise\Provider;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use PhpSpec\ObjectBehavior;

class BitlySpec extends ObjectBehavior
{
    function let(HttpClient $httpClient, RequestFactory $requestFactory)
    {
        $this->beConstructedWith('access_token', $httpClient, $requestFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Concise\Provider\Bitly');
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
                'GET',
                'https://api-ssl.bitly.com/v3/shorten?access_token=access_token&longUrl='.urlencode('http://any.url')
            )
            ->willReturn($request);
        ;

        $httpClient->sendRequest($request)->willReturn($response);
        $response->getBody()->willReturn($body);
        $body->__toString()->willReturn('{"data": {"url": "http://bit.ly/shortened"}}');

        $this->shorten('http://any.url')->shouldReturn("http://bit.ly/shortened");
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
                'https://api-ssl.bitly.com/v3/expand?access_token=access_token&shortUrl='.urlencode('http://bit.ly/shortened')
            )
            ->willReturn($request);
        ;

        $httpClient->sendRequest($request)->willReturn($response);
        $response->getBody()->willReturn($body);
        $body->__toString()->willReturn('{"data": {"expand": [{"long_url": "http://any.url"}]}}');

        $this->expand('http://bit.ly/shortened')->shouldReturn("http://any.url");
    }
}
