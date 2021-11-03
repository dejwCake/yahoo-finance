<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels\Factories;

use DejwCake\YahooFinance\ApiClient\Exceptions\UnsupportedResponseDataException;
use DejwCake\YahooFinance\ApiClient\Models\Factories\ResponseModelFactory as ResponseModelFactoryInterface;
use DejwCake\YahooFinance\Models\ResponseModels\StockQuote;
use Illuminate\Support\Collection;
use JsonException;

class StockQuoteFactory extends ResponseModelFactory implements ResponseModelFactoryInterface
{
    private const TIME_STAMP_FIELDS = [
        'regularMarketTime',
        'postMarketTime',
        'dividendDate',
        'earningsTimestamp',
        'earningsTimestampStart',
        'earningsTimestampEnd',
    ];

    public static function collection(string $json): Collection
    {
        try {
            $collectionData = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new UnsupportedResponseDataException('Json response not correct.', $jsonException);
        }

        if (
            !isset($collectionData['quoteResponse']['result'])
            || !is_array($collectionData['quoteResponse']['result'])
        ) {
            throw new UnsupportedResponseDataException();
        }

        return (new Collection($collectionData['quoteResponse']['result']))->map(
            static fn (array $stockQuoteData) => static::create(
                json_encode($stockQuoteData, JSON_THROW_ON_ERROR),
            ),
        );
    }

    public static function create(string $json): StockQuote
    {
        try {
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new UnsupportedResponseDataException('Json response not correct.', $jsonException);
        }

        parent::validateRequired($data, self::requiredFields());

        $data = parent::castCarbon($data, self::TIME_STAMP_FIELDS);

        return new StockQuote(
            $data['symbol'],
            $data['language'],
            $data['region'],
            $data['quoteType'] ?? null,
            $data['quoteSourceName'] ?? null,
            $data['triggerable'] ?? null,
            $data['currency'] ?? null,
            $data['shortName'] ?? null,
            $data['marketState'] ?? null,
            $data['exchange'] ?? null,
            $data['longName'] ?? null,
            $data['messageBoardId'] ?? null,
            $data['exchangeTimezoneName'] ?? null,
            $data['exchangeTimezoneShortName'] ?? null,
            $data['gmtOffSetMilliseconds'] ?? null,
            $data['market'] ?? null,
            $data['esgPopulated'] ?? null,
            $data['epsTrailingTwelveMonths'] ?? null,
            $data['epsForward'] ?? null,
            $data['epsCurrentYear'] ?? null,
            $data['priceEpsCurrentYear'] ?? null,
            $data['sharesOutstanding'] ?? null,
            $data['bookValue'] ?? null,
            $data['fiftyDayAverage'] ?? null,
            $data['fiftyDayAverageChange'] ?? null,
            $data['fiftyDayAverageChangePercent'] ?? null,
            $data['twoHundredDayAverage'] ?? null,
            $data['twoHundredDayAverageChange'] ?? null,
            $data['twoHundredDayAverageChangePercent'] ?? null,
            $data['marketCap'] ?? null,
            $data['forwardPE'] ?? null,
            $data['priceToBook'] ?? null,
            $data['sourceInterval'] ?? null,
            $data['exchangeDataDelayedBy'] ?? null,
            $data['averageAnalystRating'] ?? null,
            $data['firstTradeDateMilliseconds'] ?? null,
            $data['priceHint'] ?? null,
            $data['regularMarketChange'] ?? null,
            $data['regularMarketChangePercent'] ?? null,
            $data['regularMarketTime'] ?? null,
            $data['regularMarketPrice'] ?? null,
            $data['regularMarketDayHigh'] ?? null,
            $data['regularMarketDayRange'] ?? null,
            $data['regularMarketDayLow'] ?? null,
            $data['regularMarketVolume'] ?? null,
            $data['regularMarketPreviousClose'] ?? null,
            $data['postMarketChangePercent'] ?? null,
            $data['postMarketTime'] ?? null,
            $data['postMarketPrice'] ?? null,
            $data['postMarketChange'] ?? null,
            $data['bid'] ?? null,
            $data['ask'] ?? null,
            $data['bidSize'] ?? null,
            $data['askSize'] ?? null,
            $data['fullExchangeName'] ?? null,
            $data['financialCurrency'] ?? null,
            $data['regularMarketOpen'] ?? null,
            $data['averageDailyVolume3Month'] ?? null,
            $data['averageDailyVolume10Day'] ?? null,
            $data['fiftyTwoWeekLowChange'] ?? null,
            $data['fiftyTwoWeekLowChangePercent'] ?? null,
            $data['fiftyTwoWeekRange'] ?? null,
            $data['fiftyTwoWeekHighChange'] ?? null,
            $data['fiftyTwoWeekHighChangePercent'] ?? null,
            $data['fiftyTwoWeekLow'] ?? null,
            $data['fiftyTwoWeekHigh'] ?? null,
            $data['dividendDate'] ?? null,
            $data['earningsTimestamp'] ?? null,
            $data['earningsTimestampStart'] ?? null,
            $data['earningsTimestampEnd'] ?? null,
            $data['trailingAnnualDividendRate'] ?? null,
            $data['trailingPE'] ?? null,
            $data['trailingAnnualDividendYield'] ?? null,
            $data['tradeable'] ?? null,
            $data['displayName'] ?? null,
        );
    }

    public static function requiredFields(): array
    {
        return [
            'symbol',
            'language',
            'region',
        ];
    }
}
