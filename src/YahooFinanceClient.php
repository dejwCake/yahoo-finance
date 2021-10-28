<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance;

use DejwCake\YahooFinance\ApiClient\Client;
use DejwCake\YahooFinance\ApiClient\Exceptions\InternalServerErrorException;
use DejwCake\YahooFinance\ApiClient\Exceptions\NotFoundException;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedContentTypeException;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedStatusCodeException;
use DejwCake\YahooFinance\EndPoints\GetStockHistory;
use DejwCake\YahooFinance\EndPoints\GetStockQuote;
use DejwCake\YahooFinance\Models\RequestModels\GetStockHistoryRequest;
use DejwCake\YahooFinance\Models\RequestModels\GetStockQuoteRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use Illuminate\Support\Collection;
use Psr\Http\Client\ClientInterface;

class YahooFinanceClient extends Client
{
    public static function create(ClientInterface $httpClient): YahooFinanceClient
    {
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        return new static($httpClient, $requestFactory, $streamFactory);
    }

    /**
     * Stock history
     *
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws UnexpectedStatusCodeException
     * @throws UnexpectedContentTypeException
     */
    public function getStockHistory(
        GetStockHistoryRequest $getStockHistoryRequest,
        string $fetch = self::FETCH_OBJECT,
    ): ?Collection {
        return $this->executeEndpoint(new GetStockHistory($getStockHistoryRequest), $fetch);
    }

    /**
     * Real time quote data for stocks, ETFs, mutuals funds, etc…
     *
     * @throws InternalServerErrorException
     * @throws NotFoundException
     * @throws UnexpectedStatusCodeException
     * @throws UnexpectedContentTypeException
     */
    public function getStockQuote(
        GetStockQuoteRequest $getStockQuoteRequest,
        string $fetch = self::FETCH_OBJECT,
    ): ?Collection {
        return $this->executeEndpoint(new GetStockQuote($getStockQuoteRequest), $fetch);
    }
}
