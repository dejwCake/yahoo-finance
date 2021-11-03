<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels;

use Carbon\Carbon;
use DejwCake\YahooFinance\ApiClient\Models\ResponseModel as ResponseModelInterface;

class StockQuote implements ResponseModelInterface
{
    public function __construct(
        private string $symbol,
        private string $language,
        private string $region,
        private ?string $quoteType,
        private ?string $quoteSourceName,
        private ?bool $triggerable,
        private ?string $currency,
        private ?string $shortName,
        private ?string $marketState,
        private ?string $exchange,
        private ?string $longName,
        private ?string $messageBoardId,
        private ?string $exchangeTimezoneName,
        private ?string $exchangeTimezoneShortName,
        private ?int $gmtOffSetMilliseconds,
        private ?string $market,
        private ?bool $esgPopulated,
        private ?float $epsTrailingTwelveMonths,
        private ?float $epsForward,
        private ?float $epsCurrentYear,
        private ?float $priceEpsCurrentYear,
        private ?int $sharesOutstanding,
        private ?float $bookValue,
        private ?float $fiftyDayAverage,
        private ?float $fiftyDayAverageChange,
        private ?float $fiftyDayAverageChangePercent,
        private ?float $twoHundredDayAverage,
        private ?float $twoHundredDayAverageChange,
        private ?float $twoHundredDayAverageChangePercent,
        private ?int $marketCap,
        private ?float $forwardPE,
        private ?float $priceToBook,
        private ?int $sourceInterval,
        private ?int $exchangeDataDelayedBy,
        private ?string $averageAnalystRating,
        private ?int $firstTradeDateMilliseconds,
        private ?int $priceHint,
        private ?float $regularMarketChange,
        private ?float $regularMarketChangePercent,
        private ?Carbon $regularMarketTime,
        private ?float $regularMarketPrice,
        private ?float $regularMarketDayHigh,
        private ?string $regularMarketDayRange,
        private ?float $regularMarketDayLow,
        private ?int $regularMarketVolume,
        private ?float $regularMarketPreviousClose,
        private ?float $postMarketChangePercent,
        private ?Carbon $postMarketTime,
        private ?float $postMarketPrice,
        private ?float $postMarketChange,
        private ?float $bid,
        private ?float $ask,
        private ?int $bidSize,
        private ?int $askSize,
        private ?string $fullExchangeName,
        private ?string $financialCurrency,
        private ?float $regularMarketOpen,
        private ?int $averageDailyVolume3Month,
        private ?int $averageDailyVolume10Day,
        private ?float $fiftyTwoWeekLowChange,
        private ?float $fiftyTwoWeekLowChangePercent,
        private ?string $fiftyTwoWeekRange,
        private ?float $fiftyTwoWeekHighChange,
        private ?float $fiftyTwoWeekHighChangePercent,
        private ?float $fiftyTwoWeekLow,
        private ?float $fiftyTwoWeekHigh,
        private ?Carbon $dividendDate,
        private ?Carbon $earningsTimestamp,
        private ?Carbon $earningsTimestampStart,
        private ?Carbon $earningsTimestampEnd,
        private ?float $trailingAnnualDividendRate,
        private ?float $trailingPE,
        private ?float $trailingAnnualDividendYield,
        private ?bool $tradeable,
        private ?string $displayName,
    ) {
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

    public function getQuoteType(): ?string
    {
        return $this->quoteType;
    }

    public function getQuoteSourceName(): ?string
    {
        return $this->quoteSourceName;
    }

    public function getTriggerable(): ?bool
    {
        return $this->triggerable;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function getMarketState(): ?string
    {
        return $this->marketState;
    }

    public function getExchange(): ?string
    {
        return $this->exchange;
    }

    public function getLongName(): ?string
    {
        return $this->longName;
    }

    public function getMessageBoardId(): ?string
    {
        return $this->messageBoardId;
    }

    public function getExchangeTimezoneName(): ?string
    {
        return $this->exchangeTimezoneName;
    }

    public function getExchangeTimezoneShortName(): ?string
    {
        return $this->exchangeTimezoneShortName;
    }

    public function getGmtOffSetMilliseconds(): ?int
    {
        return $this->gmtOffSetMilliseconds;
    }

    public function getMarket(): ?string
    {
        return $this->market;
    }

    public function getEsgPopulated(): ?bool
    {
        return $this->esgPopulated;
    }

    public function getEpsTrailingTwelveMonths(): ?float
    {
        return $this->epsTrailingTwelveMonths;
    }

    public function getEpsForward(): ?float
    {
        return $this->epsForward;
    }

    public function getEpsCurrentYear(): ?float
    {
        return $this->epsCurrentYear;
    }

    public function getPriceEpsCurrentYear(): ?float
    {
        return $this->priceEpsCurrentYear;
    }

    public function getSharesOutstanding(): ?int
    {
        return $this->sharesOutstanding;
    }

    public function getBookValue(): ?float
    {
        return $this->bookValue;
    }

    public function getFiftyDayAverage(): ?float
    {
        return $this->fiftyDayAverage;
    }

    public function getFiftyDayAverageChange(): ?float
    {
        return $this->fiftyDayAverageChange;
    }

    public function getFiftyDayAverageChangePercent(): ?float
    {
        return $this->fiftyDayAverageChangePercent;
    }

    public function getTwoHundredDayAverage(): ?float
    {
        return $this->twoHundredDayAverage;
    }

    public function getTwoHundredDayAverageChange(): ?float
    {
        return $this->twoHundredDayAverageChange;
    }

    public function getTwoHundredDayAverageChangePercent(): ?float
    {
        return $this->twoHundredDayAverageChangePercent;
    }

    public function getMarketCap(): ?int
    {
        return $this->marketCap;
    }

    public function getForwardPE(): ?float
    {
        return $this->forwardPE;
    }

    public function getPriceToBook(): ?float
    {
        return $this->priceToBook;
    }

    public function getSourceInterval(): ?int
    {
        return $this->sourceInterval;
    }

    public function getExchangeDataDelayedBy(): ?int
    {
        return $this->exchangeDataDelayedBy;
    }

    public function getAverageAnalystRating(): ?string
    {
        return $this->averageAnalystRating;
    }

    public function getFirstTradeDateMilliseconds(): ?int
    {
        return $this->firstTradeDateMilliseconds;
    }

    public function getPriceHint(): ?int
    {
        return $this->priceHint;
    }

    public function getRegularMarketChange(): ?float
    {
        return $this->regularMarketChange;
    }

    public function getRegularMarketChangePercent(): ?float
    {
        return $this->regularMarketChangePercent;
    }

    public function getRegularMarketTime(): ?Carbon
    {
        return $this->regularMarketTime;
    }

    public function getRegularMarketPrice(): ?float
    {
        return $this->regularMarketPrice;
    }

    public function getRegularMarketDayHigh(): ?float
    {
        return $this->regularMarketDayHigh;
    }

    public function getRegularMarketDayRange(): ?string
    {
        return $this->regularMarketDayRange;
    }

    public function getRegularMarketDayLow(): ?float
    {
        return $this->regularMarketDayLow;
    }

    public function getRegularMarketVolume(): ?int
    {
        return $this->regularMarketVolume;
    }

    public function getRegularMarketPreviousClose(): ?float
    {
        return $this->regularMarketPreviousClose;
    }

    public function getPostMarketChangePercent(): ?float
    {
        return $this->postMarketChangePercent;
    }

    public function getPostMarketTime(): ?Carbon
    {
        return $this->postMarketTime;
    }

    public function getPostMarketPrice(): ?float
    {
        return $this->postMarketPrice;
    }

    public function getPostMarketChange(): ?float
    {
        return $this->postMarketChange;
    }

    public function getBid(): ?float
    {
        return $this->bid;
    }

    public function getAsk(): ?float
    {
        return $this->ask;
    }

    public function getBidSize(): ?int
    {
        return $this->bidSize;
    }

    public function getAskSize(): ?int
    {
        return $this->askSize;
    }

    public function getFullExchangeName(): ?string
    {
        return $this->fullExchangeName;
    }

    public function getFinancialCurrency(): ?string
    {
        return $this->financialCurrency;
    }

    public function getRegularMarketOpen(): ?float
    {
        return $this->regularMarketOpen;
    }

    public function getAverageDailyVolume3Month(): ?int
    {
        return $this->averageDailyVolume3Month;
    }

    public function getAverageDailyVolume10Day(): ?int
    {
        return $this->averageDailyVolume10Day;
    }

    public function getFiftyTwoWeekLowChange(): ?float
    {
        return $this->fiftyTwoWeekLowChange;
    }

    public function getFiftyTwoWeekLowChangePercent(): ?float
    {
        return $this->fiftyTwoWeekLowChangePercent;
    }

    public function getFiftyTwoWeekRange(): ?string
    {
        return $this->fiftyTwoWeekRange;
    }

    public function getFiftyTwoWeekHighChange(): ?float
    {
        return $this->fiftyTwoWeekHighChange;
    }

    public function getFiftyTwoWeekHighChangePercent(): ?float
    {
        return $this->fiftyTwoWeekHighChangePercent;
    }

    public function getFiftyTwoWeekLow(): ?float
    {
        return $this->fiftyTwoWeekLow;
    }

    public function getFiftyTwoWeekHigh(): ?float
    {
        return $this->fiftyTwoWeekHigh;
    }

    public function getDividendDate(): ?Carbon
    {
        return $this->dividendDate;
    }

    public function getEarningsTimestamp(): ?Carbon
    {
        return $this->earningsTimestamp;
    }

    public function getEarningsTimestampStart(): ?Carbon
    {
        return $this->earningsTimestampStart;
    }

    public function getEarningsTimestampEnd(): ?Carbon
    {
        return $this->earningsTimestampEnd;
    }

    public function getTrailingAnnualDividendRate(): ?float
    {
        return $this->trailingAnnualDividendRate;
    }

    public function getTrailingPE(): ?float
    {
        return $this->trailingPE;
    }

    public function getTrailingAnnualDividendYield(): ?float
    {
        return $this->trailingAnnualDividendYield;
    }

    public function getTradeable(): ?bool
    {
        return $this->tradeable;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }
}
