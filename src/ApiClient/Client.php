<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient;

use DejwCake\YahooFinance\ApiClient\EndPoints\Endpoint;
use DejwCake\YahooFinance\ApiClient\Models\ResponseModel;
use Illuminate\Support\Collection;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

abstract class Client
{
    public const FETCH_RESPONSE = 'response';
    public const FETCH_OBJECT = 'object';

    public function __construct(
        protected ClientInterface $httpClient,
        protected RequestFactoryInterface $requestFactory,
        protected StreamFactoryInterface $streamFactory,
    ) {
    }

    public function executeEndpoint(
        Endpoint $endpoint,
        string $fetch = self::FETCH_OBJECT,
    ): ResponseModel|Collection|null {
        [$bodyHeaders, $body] = $endpoint->getBody($this->streamFactory);
        $queryString = $endpoint->getQueryString();
        $uriGlue = !str_contains($endpoint->getUri(), '?') ? '?' : '&';
        $uri = $queryString !== '' ? $endpoint->getUri() . $uriGlue . $queryString : $endpoint->getUri();
        $request = $this->requestFactory->createRequest($endpoint->getMethod(), $uri);
        if ($body) {
            if ($body instanceof StreamInterface) {
                $request = $request->withBody($body);
            } elseif (is_resource($body)) {
                $request = $request->withBody($this->streamFactory->createStreamFromResource($body));
            } elseif (is_file($body)) {
                $request = $request->withBody($this->streamFactory->createStreamFromFile($body));
            } else {
                $request = $request->withBody($this->streamFactory->createStream($body));
            }
        }
        foreach ($endpoint->getHeaders($bodyHeaders) as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $endpoint->parseResponse($this->httpClient->sendRequest($request), $fetch);
    }
}
