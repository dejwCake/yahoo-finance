<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\EndPoints;

use DejwCake\YahooFinance\ApiClient\Client;
use DejwCake\YahooFinance\ApiClient\Exceptions\InternalServerErrorException;
use DejwCake\YahooFinance\ApiClient\Exceptions\InvalidFetchModeException;
use DejwCake\YahooFinance\ApiClient\Exceptions\NotFoundException;
use DejwCake\YahooFinance\ApiClient\Models\ResponseModel;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class BaseEndpoint implements Endpoint
{
    /** @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingTraversableTypeHintSpecification */
    protected array $queryParameters = [];

    /** @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingTraversableTypeHintSpecification */
    protected array $headerParameters = [];

    /** @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingTraversableTypeHintSpecification */
    protected array $formParameters = [];

    /** @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingTraversableTypeHintSpecification */
    protected array $body = [];

    abstract public function getMethod(): string;

    abstract public function getBody(?StreamFactoryInterface $streamFactory = null): array;

    abstract public function getUri(): string;

    abstract protected function transformResponseBody(
        string $body,
        int $status,
        ?string $contentType,
    ): ResponseModel|Collection|null;

    public function getQueryString(): string
    {
        $queryParameters = array_map(static fn ($value) => $value ?? '', $this->queryParameters);

        return http_build_query($queryParameters, '', '&', PHP_QUERY_RFC3986);
    }

    public function getHeaders(array $baseHeaders = []): array
    {
        return array_merge($this->getExtraHeaders(), $baseHeaders, $this->headerParameters);
    }

    public function parseResponse(
        ResponseInterface $response,
        string $fetchMode = Client::FETCH_OBJECT,
    ): ResponseModel|Collection|ResponseInterface|null {
        if ($fetchMode === Client::FETCH_OBJECT) {
            $contentType = $response->hasHeader('Content-Type')
                ? current($response->getHeader('Content-Type'))
                : null;

            if ($response->getStatusCode() === 500) {
                throw new InternalServerErrorException();
            }

            if ($response->getStatusCode() === 404) {
                throw new NotFoundException();
            }

            return $this->transformResponseBody(
                (string) $response->getBody(),
                $response->getStatusCode(),
                $contentType,
            );
        }

        if ($fetchMode === Client::FETCH_RESPONSE) {
            return $response;
        }

        throw new InvalidFetchModeException(sprintf('Fetch mode %s is not supported', $fetchMode));
    }

    protected function getExtraHeaders(): array
    {
        return [];
    }

// ----------------------------------------------------------------------------------------------------
    protected function getFormBody(): array
    {
        return [['Content-Type' => ['application/x-www-form-urlencoded']], http_build_query($this->formParameters)];
    }

    protected function getSerializedBody(): array
    {
        return [['Content-Type' => ['application/json']], json_encode($this->body, JSON_THROW_ON_ERROR)];
    }
}
