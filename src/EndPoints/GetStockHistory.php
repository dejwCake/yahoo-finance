<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\EndPoints;

use DejwCake\YahooFinance\ApiClient\EndPoints\BaseEndpoint;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedContentTypeException;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedStatusCodeException;
use DejwCake\YahooFinance\Models\RequestModels\GetStockHistoryRequest;
use DejwCake\YahooFinance\Models\ResponseModels\Factories\StockHistoryFactory;
use Illuminate\Support\Collection;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;

class GetStockHistory extends BaseEndpoint
{
    private const URI = '/v8/finance/spark';

    public function __construct(
        GetStockHistoryRequest $getStockHistoryRequest,
        private readonly LoggerInterface $logger,
    ) {
        $this->queryParameters = [
            'symbols' => $getStockHistoryRequest->getSymbolsAsString(),
            'interval' => $getStockHistoryRequest->getInterval()->value,
            'range' => $getStockHistoryRequest->getRange()->value,
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
                $stockHistoryFactory = new StockHistoryFactory($this->logger);

                return $stockHistoryFactory->collection($body);
            }

            throw new UnexpectedContentTypeException($contentType);
        }

        throw new UnexpectedStatusCodeException($status);
    }
}
