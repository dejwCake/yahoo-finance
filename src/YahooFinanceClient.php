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
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;

class YahooFinanceClient extends Client
{
    private function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        protected readonly LoggerInterface $logger,
    ) {
        parent::__construct($httpClient, $requestFactory, $streamFactory);
    }

    public static function create(ClientInterface $httpClient, LoggerInterface $logger): self
    {
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        return new static($httpClient, $requestFactory, $streamFactory, $logger);
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
        return $this->executeEndpoint(new GetStockHistory($getStockHistoryRequest, $this->logger), $fetch);
    }

    /**
     * Real time quote data for stocks, ETFs, mutual funds, etc…
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
        return $this->executeEndpoint(new GetStockQuote($getStockQuoteRequest, $this->logger), $fetch);
    }
}
