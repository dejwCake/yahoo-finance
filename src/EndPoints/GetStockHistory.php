<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\EndPoints;

use DejwCake\YahooFinance\ApiClient\EndPoints\BaseEndpoint;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedContentTypeException;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedStatusCodeException;
use DejwCake\YahooFinance\Models\RequestModels\GetStockHistoryRequest;
use DejwCake\YahooFinance\Models\ResponseModels\StockHistory;
use Illuminate\Support\Collection;
use Psr\Http\Message\StreamFactoryInterface;

class GetStockHistory extends BaseEndpoint
{
    private const URI = '/v8/finance/spark';

    public function __construct(GetStockHistoryRequest $getStockHistoryRequest)
    {
        $this->queryParameters = [
            'symbols' => $getStockHistoryRequest->getSymbolsAsString(),
            'interval' => (string) $getStockHistoryRequest->getInterval(),
            'range' => (string) $getStockHistoryRequest->getRange(),
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
                return StockHistory::collectionFromJson($body);
            }

            throw new UnexpectedContentTypeException($contentType);
        }

        throw new UnexpectedStatusCodeException($status);
    }
}
