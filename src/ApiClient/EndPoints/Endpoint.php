<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\EndPoints;

use DejwCake\YahooFinance\ApiClient\Client;
use DejwCake\YahooFinance\ApiClient\Models\ResponseModel;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

interface Endpoint
{
    /**
     * Get body for an endpoint.
     *
     * Return value consist of an array where
     * the first item will be a list of headers to add on the request (like the Content Type)
     * and the second value consist of the body object.
     */
    public function getBody(?StreamFactoryInterface $streamFactory = null): array;

    /**
     * Get the query string of an endpoint without the starting ? (like foo=foo&bar=bar).
     */
    public function getQueryString(): string;

    /**
     * Get the URI of an endpoint (like /foo-uri).
     */
    public function getUri(): string;

    /**
     * Get the HTTP method of an endpoint (like GET, POST, ...).
     */
    public function getMethod(): string;

    /**
     * Get the headers of an endpoint.
     */
    public function getHeaders(array $baseHeaders = []): array;

    /**
     * Parse and transform a PSR7 Response into a different object.
     *
     * Implementations may vary depending on the status code of the response and the fetch mode used.
     */
    public function parseResponse(
        ResponseInterface $response,
        string $fetchMode = Client::FETCH_OBJECT,
    ): ResponseModel|Collection|ResponseInterface|null;
}
