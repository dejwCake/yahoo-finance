<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\EndPoints;

use DejwCake\YahooFinance\ApiClient\EndPoints\BaseEndpoint;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedContentTypeException;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedStatusCodeException;
use DejwCake\YahooFinance\Models\RequestModels\GetStockQuoteRequest;
use DejwCake\YahooFinance\Models\ResponseModels\Factories\StockQuoteFactory;
use Illuminate\Support\Collection;
use Psr\Http\Message\StreamFactoryInterface;

class GetStockQuote extends BaseEndpoint
{
    private const URI = '/v6/finance/quote';

    public function __construct(GetStockQuoteRequest $getStockQuoteRequest)
    {
        $this->queryParameters = [
            'symbols' => $getStockQuoteRequest->getSymbolsAsString(),
            'region' => (string) $getStockQuoteRequest->getRegion(),
            'lang' => (string) $getStockQuoteRequest->getLang(),
        ];
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getUri(): string
    {
        return self::URI;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getBody(?StreamFactoryInterface $streamFactory = null): array
    {
        return [[], null];
    }

    public function getExtraHeaders(): array
    {
        return ['Accept' => ['application/json']];
    }

    protected function transformResponseBody(string $body, int $status, ?string $contentType = null): ?Collection
    {
        if ($status === 200) {
            if (str_contains($contentType, 'application/json')) {
                return StockQuoteFactory::collection($body);
            }

            throw new UnexpectedContentTypeException($contentType);
        }

        throw new UnexpectedStatusCodeException($status);
    }
}
