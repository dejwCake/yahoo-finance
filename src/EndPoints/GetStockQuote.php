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
use Psr\Log\LoggerInterface;

class GetStockQuote extends BaseEndpoint
{
    private const URI = '/v6/finance/quote';

    public function __construct(GetStockQuoteRequest $getStockQuoteRequest, private readonly LoggerInterface $logger)
    {
        $this->queryParameters = [
            'symbols' => $getStockQuoteRequest->getSymbolsAsString(),
            'region' => $getStockQuoteRequest->region->value,
            'lang' => $getStockQuoteRequest->lang->value,
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
                $stockQuoteFactory = new StockQuoteFactory($this->logger);

                return $stockQuoteFactory->collection($body);
            }

            throw new UnexpectedContentTypeException($contentType);
        }

        throw new UnexpectedStatusCodeException($status);
    }
}
