<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels;

use Carbon\Carbon;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnsupportedResponseDataException;
use DejwCake\YahooFinance\ApiClient\Models\ResponseModel as ResponseModelInterface;
use DejwCake\YahooFinance\Models\CloseValue;
use Illuminate\Support\Collection;

class StockQuote extends ResponseModel implements ResponseModelInterface
{
    private const TIME_STAMP_FIELDS = [
        'firstTradeDateMilliseconds',
        'regularMarketTime',
        'dividendDate',
        'earningsTimestamp',
        'earningsTimestampStart',
        'earningsTimestampEnd',
    ];

    public function __construct(
        private string $symbol,
        private string $language,
        private string $region,
        private string $quoteType,
        private string $quoteSourceName,
        private bool $triggerable,
        private string $currency,
        private string $shortName,
        private string $marketState,
        private string $exchange,
        private string $longName,
        private string $messageBoardId,
        private string $exchangeTimezoneName,
        private string $exchangeTimezoneShortName,
        private int $gmtOffSetMilliseconds,
        private string $market,
        private bool $esgPopulated,
        private float $epsTrailingTwelveMonths,
        private float $epsForward,
        private float $epsCurrentYear,
        private float $priceEpsCurrentYear,
        private int $sharesOutstanding,
        private float $bookValue,
        private float $fiftyDayAverage,
        private float $fiftyDayAverageChange,
        private float $fiftyDayAverageChangePercent,
        private float $twoHundredDayAverage,
        private float $twoHundredDayAverageChange,
        private float $twoHundredDayAverageChangePercent,
        private int $marketCap,
        private float $forwardPE,
        private float $priceToBook,
        private int $sourceInterval,
        private int $exchangeDataDelayedBy,
        private string $averageAnalystRating,
        private Carbon $firstTradeDateMilliseconds,
        private int $priceHint,
        private float $regularMarketChange,
        private float $regularMarketChangePercent,
        private Carbon $regularMarketTime,
        private float $regularMarketPrice,
        private float $regularMarketDayHigh,
        private string $regularMarketDayRange,
        private float $regularMarketDayLow,
        private int $regularMarketVolume,
        private float $regularMarketPreviousClose,
        private float $bid,
        private float $ask,
        private int $bidSize,
        private int $askSize,
        private string $fullExchangeName,
        private string $financialCurrency,
        private float $regularMarketOpen,
        private int $averageDailyVolume3Month,
        private int $averageDailyVolume10Day,
        private float $fiftyTwoWeekLowChange,
        private float $fiftyTwoWeekLowChangePercent,
        private string $fiftyTwoWeekRange,
        private float $fiftyTwoWeekHighChange,
        private float $fiftyTwoWeekHighChangePercent,
        private float $fiftyTwoWeekLow,
        private float $fiftyTwoWeekHigh,
        private Carbon $dividendDate,
        private Carbon $earningsTimestamp,
        private Carbon $earningsTimestampStart,
        private Carbon $earningsTimestampEnd,
        private float $trailingAnnualDividendRate,
        private float $trailingPE,
        private float $trailingAnnualDividendYield,
        private bool $tradeable,
        private string $displayName,
    ) {
    }

    public static function collectionFromJson(string $json): Collection
    {
        $collectionData = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        if (
            !isset($collectionData['quoteResponse']['result'])
            || !is_array($collectionData['quoteResponse']['result'])
        ) {
            throw new UnsupportedResponseDataException();
        }

        return (new Collection($collectionData['quoteResponse']['result']))->map(
            static fn(array $stockQuoteData) => static::fromJson(
                json_encode($stockQuoteData, JSON_THROW_ON_ERROR),
            ),
        );
    }

    public static function fromJson(string $json): static
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        parent::validate($data, self::rules($data));
        $data = parent::castCarbon($data, self::TIME_STAMP_FIELDS);

        $closeValues = new Collection();
        foreach ($data['timestamp'] as $key => $timestamp) {
            $closeValues->push(
                new CloseValue(Carbon::createFromTimestamp($timestamp), $data['close'][$key]),
            );
        }

        return new static(
            $data['symbol'],
            $data['previousClose'] ?? null,
            $data['start'] ?? null,
            $data['end'] ?? null,
            $data['chartPreviousClose'],
            $data['dataGranularity'],
            $closeValues,
        );
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public static function rules(array $data): array
    {
        return [
            'symbol' => ['required', 'string'],
            'language' => ['required', 'string'],
            'region' => ['required', 'string'],
            'quoteType' => ['required', 'string'],
            'quoteSourceName' => ['required', 'string'],
            'triggerable' => ['required', 'boolean'],
            'currency' => ['required', 'string'],
            'shortName' => ['required', 'string'],
            'marketState' => ['required', 'string'],
            'exchange' => ['required', 'string'],
            'longName' => ['required', 'string'],
            'messageBoardId' => ['required', 'string'],
            'exchangeTimezoneName' => ['required', 'string'],
            'exchangeTimezoneShortName' => ['required', 'string'],
            'gmtOffSetMilliseconds' => ['required', 'numeric'],
            'market' => ['required', 'string'],
            'esgPopulated' => ['required', 'boolean'],
            'epsTrailingTwelveMonths' => ['required', 'numeric'],
            'epsForward' => ['required', 'numeric'],
            'epsCurrentYear' => ['required', 'numeric'],
            'priceEpsCurrentYear' => ['required', 'numeric'],
            'sharesOutstanding' => ['required', 'numeric'],
            'bookValue' => ['required', 'numeric'],
            'fiftyDayAverage' => ['required', 'numeric'],
            'fiftyDayAverageChange' => ['required', 'numeric'],
            'fiftyDayAverageChangePercent' => ['required', 'numeric'],
            'twoHundredDayAverage' => ['required', 'numeric'],
            'twoHundredDayAverageChange' => ['required', 'numeric'],
            'twoHundredDayAverageChangePercent' => ['required', 'numeric'],
            'marketCap' => ['required', 'numeric'],
            'forwardPE' => ['required', 'numeric'],
            'priceToBook' => ['required', 'numeric'],
            'sourceInterval' => ['required', 'numeric'],
            'exchangeDataDelayedBy' => ['required', 'numeric'],
            'averageAnalystRating' => ['required', 'string'],
            'firstTradeDateMilliseconds' => ['required', 'numeric'],
            'priceHint' => ['required', 'numeric'],
            'regularMarketChange' => ['required', 'numeric'],
            'regularMarketChangePercent' => ['required', 'numeric'],
            'regularMarketTime' => ['required', 'numeric'],
            'regularMarketPrice' => ['required', 'numeric'],
            'regularMarketDayHigh' => ['required', 'numeric'],
            'regularMarketDayRange' => ['required', 'string'],
            'regularMarketDayLow' => ['required', 'numeric'],
            'regularMarketVolume' => ['required', 'numeric'],
            'regularMarketPreviousClose' => ['required', 'numeric'],
            'bid' => ['required', 'numeric'],
            'ask' => ['required', 'numeric'],
            'bidSize' => ['required', 'numeric'],
            'askSize' => ['required', 'numeric'],
            'fullExchangeName' => ['required', 'string'],
            'financialCurrency' => ['required', 'string'],
            'regularMarketOpen' => ['required', 'numeric'],
            'averageDailyVolume3Month' => ['required', 'numeric'],
            'averageDailyVolume10Day' => ['required', 'numeric'],
            'fiftyTwoWeekLowChange' => ['required', 'numeric'],
            'fiftyTwoWeekLowChangePercent' => ['required', 'numeric'],
            'fiftyTwoWeekRange' => ['required', 'string'],
            'fiftyTwoWeekHighChange' => ['required', 'numeric'],
            'fiftyTwoWeekHighChangePercent' => ['required', 'numeric'],
            'fiftyTwoWeekLow' => ['required', 'numeric'],
            'fiftyTwoWeekHigh' => ['required', 'numeric'],
            'dividendDate' => ['required', 'numeric'],
            'earningsTimestamp' => ['required', 'numeric'],
            'earningsTimestampStart' => ['required', 'numeric'],
            'earningsTimestampEnd' => ['required', 'numeric'],
            'trailingAnnualDividendRate' => ['required', 'numeric'],
            'trailingPE' => ['required', 'numeric'],
            'trailingAnnualDividendYield' => ['required', 'numeric'],
            'tradeable' => ['required', 'boolean'],
            'displayName' => ['required', 'string'],
        ];
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getQuoteType(): string
    {
        return $this->quoteType;
    }

    public function getQuoteSourceName(): string
    {
        return $this->quoteSourceName;
    }

    public function isTriggerable(): bool
    {
        return $this->triggerable;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function getMarketState(): string
    {
        return $this->marketState;
    }

    public function getExchange(): string
    {
        return $this->exchange;
    }

    public function getLongName(): string
    {
        return $this->longName;
    }

    public function getMessageBoardId(): string
    {
        return $this->messageBoardId;
    }

    public function getExchangeTimezoneName(): string
    {
        return $this->exchangeTimezoneName;
    }

    public function getExchangeTimezoneShortName(): string
    {
        return $this->exchangeTimezoneShortName;
    }

    public function getGmtOffSetMilliseconds(): int
    {
        return $this->gmtOffSetMilliseconds;
    }

    public function getMarket(): string
    {
        return $this->market;
    }

    public function isEsgPopulated(): bool
    {
        return $this->esgPopulated;
    }

    public function getEpsTrailingTwelveMonths(): float
    {
        return $this->epsTrailingTwelveMonths;
    }

    public function getEpsForward(): float
    {
        return $this->epsForward;
    }

    public function getEpsCurrentYear(): float
    {
        return $this->epsCurrentYear;
    }

    public function getPriceEpsCurrentYear(): float
    {
        return $this->priceEpsCurrentYear;
    }

    public function getSharesOutstanding(): int
    {
        return $this->sharesOutstanding;
    }

    public function getBookValue(): float
    {
        return $this->bookValue;
    }

    public function getFiftyDayAverage(): float
    {
        return $this->fiftyDayAverage;
    }

    public function getFiftyDayAverageChange(): float
    {
        return $this->fiftyDayAverageChange;
    }

    public function getFiftyDayAverageChangePercent(): float
    {
        return $this->fiftyDayAverageChangePercent;
    }

    public function getTwoHundredDayAverage(): float
    {
        return $this->twoHundredDayAverage;
    }

    public function getTwoHundredDayAverageChange(): float
    {
        return $this->twoHundredDayAverageChange;
    }

    public function getTwoHundredDayAverageChangePercent(): float
    {
        return $this->twoHundredDayAverageChangePercent;
    }

    public function getMarketCap(): int
    {
        return $this->marketCap;
    }

    public function getForwardPE(): float
    {
        return $this->forwardPE;
    }

    public function getPriceToBook(): float
    {
        return $this->priceToBook;
    }

    public function getSourceInterval(): int
    {
        return $this->sourceInterval;
    }

    public function getExchangeDataDelayedBy(): int
    {
        return $this->exchangeDataDelayedBy;
    }

    public function getAverageAnalystRating(): string
    {
        return $this->averageAnalystRating;
    }

    public function getFirstTradeDateMilliseconds(): Carbon
    {
        return $this->firstTradeDateMilliseconds;
    }

    public function getPriceHint(): int
    {
        return $this->priceHint;
    }

    public function getRegularMarketChange(): float
    {
        return $this->regularMarketChange;
    }

    public function getRegularMarketChangePercent(): float
    {
        return $this->regularMarketChangePercent;
    }

    public function getRegularMarketTime(): Carbon
    {
        return $this->regularMarketTime;
    }

    public function getRegularMarketPrice(): float
    {
        return $this->regularMarketPrice;
    }

    public function getRegularMarketDayHigh(): float
    {
        return $this->regularMarketDayHigh;
    }

    public function getRegularMarketDayRange(): string
    {
        return $this->regularMarketDayRange;
    }

    public function getRegularMarketDayLow(): float
    {
        return $this->regularMarketDayLow;
    }

    public function getRegularMarketVolume(): int
    {
        return $this->regularMarketVolume;
    }

    public function getRegularMarketPreviousClose(): float
    {
        return $this->regularMarketPreviousClose;
    }

    public function getBid(): float
    {
        return $this->bid;
    }

    public function getAsk(): float
    {
        return $this->ask;
    }

    public function getBidSize(): int
    {
        return $this->bidSize;
    }

    public function getAskSize(): int
    {
        return $this->askSize;
    }

    public function getFullExchangeName(): string
    {
        return $this->fullExchangeName;
    }

    public function getFinancialCurrency(): string
    {
        return $this->financialCurrency;
    }

    public function getRegularMarketOpen(): float
    {
        return $this->regularMarketOpen;
    }

    public function getAverageDailyVolume3Month(): int
    {
        return $this->averageDailyVolume3Month;
    }

    public function getAverageDailyVolume10Day(): int
    {
        return $this->averageDailyVolume10Day;
    }

    public function getFiftyTwoWeekLowChange(): float
    {
        return $this->fiftyTwoWeekLowChange;
    }

    public function getFiftyTwoWeekLowChangePercent(): float
    {
        return $this->fiftyTwoWeekLowChangePercent;
    }

    public function getFiftyTwoWeekRange(): string
    {
        return $this->fiftyTwoWeekRange;
    }

    public function getFiftyTwoWeekHighChange(): float
    {
        return $this->fiftyTwoWeekHighChange;
    }

    public function getFiftyTwoWeekHighChangePercent(): float
    {
        return $this->fiftyTwoWeekHighChangePercent;
    }

    public function getFiftyTwoWeekLow(): float
    {
        return $this->fiftyTwoWeekLow;
    }

    public function getFiftyTwoWeekHigh(): float
    {
        return $this->fiftyTwoWeekHigh;
    }

    public function getDividendDate(): int
    {
        return $this->dividendDate;
    }

    public function getEarningsTimestamp(): Carbon
    {
        return $this->earningsTimestamp;
    }

    public function getEarningsTimestampStart(): Carbon
    {
        return $this->earningsTimestampStart;
    }

    public function getEarningsTimestampEnd(): Carbon
    {
        return $this->earningsTimestampEnd;
    }

    public function getTrailingAnnualDividendRate(): float
    {
        return $this->trailingAnnualDividendRate;
    }

    public function getTrailingPE(): float
    {
        return $this->trailingPE;
    }

    public function getTrailingAnnualDividendYield(): float
    {
        return $this->trailingAnnualDividendYield;
    }

    public function isTradeable(): bool
    {
        return $this->tradeable;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }
}
