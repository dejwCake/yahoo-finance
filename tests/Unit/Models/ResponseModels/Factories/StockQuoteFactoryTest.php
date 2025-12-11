<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Tests\Unit\Models\ResponseModels\Factories;

use DejwCake\YahooFinance\ApiClient\Exceptions\UnsupportedResponseDataException;
use DejwCake\YahooFinance\Models\ResponseModels\Factories\StockQuoteFactory;
use DejwCake\YahooFinance\Models\ResponseModels\StockQuote;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

// phpcs:disable SlevomatCodingStandard.Files.LineLength.LineTooLong
class StockQuoteFactoryTest extends TestCase
{
    public function testCanGetFromJson(): void
    {
        $json = '{"language":"en-US","region":"US","quoteType":"EQUITY","quoteSourceName":"Nasdaq Real Time Price","triggerable":true,"firstTradeDateMilliseconds":345479400000,"priceHint":2,"postMarketChangePercent":-0.039615035,"postMarketTime":1635972709,"postMarketPrice":151.43,"postMarketChange":-0.060012817,"regularMarketChange":1.4700012,"regularMarketChangePercent":0.9798701,"regularMarketTime":1635969603,"regularMarketPrice":151.49,"regularMarketDayHigh":151.97,"regularMarketDayRange":"149.83 - 151.97","regularMarketDayLow":149.83,"regularMarketVolume":51035964,"regularMarketPreviousClose":150.02,"bid":151.5,"ask":151.51,"bidSize":11,"askSize":11,"fullExchangeName":"NasdaqGS","financialCurrency":"USD","regularMarketOpen":150.39,"averageDailyVolume3Month":75443843,"averageDailyVolume10Day":76612900,"fiftyTwoWeekLowChange":39.140007,"fiftyTwoWeekLowChangePercent":0.34837568,"fiftyTwoWeekRange":"112.35 - 157.26","fiftyTwoWeekHighChange":-5.769989,"fiftyTwoWeekHighChangePercent":-0.03669076,"fiftyTwoWeekLow":112.35,"fiftyTwoWeekHigh":157.26,"dividendDate":1636588800,"earningsTimestamp":1635438600,"earningsTimestampStart":1643108340,"earningsTimestampEnd":1643630400,"trailingAnnualDividendRate":0.85,"trailingPE":27.003565,"trailingAnnualDividendYield":0.0056659114,"epsTrailingTwelveMonths":5.61,"epsForward":6.12,"currency":"USD","epsCurrentYear":5.73,"priceEpsCurrentYear":26.438046,"sharesOutstanding":16406400000,"bookValue":3.841,"fiftyDayAverage":145.70555,"fiftyDayAverageChange":5.7844543,"fiftyDayAverageChangePercent":0.039699614,"twoHundredDayAverage":140.34676,"twoHundredDayAverageChange":11.1432495,"twoHundredDayAverageChangePercent":0.079397984,"marketCap":2485405614080,"forwardPE":24.75327,"priceToBook":39.44025,"sourceInterval":15,"exchangeDataDelayedBy":0,"averageAnalystRating":"1.9 - Buy","tradeable":false,"exchange":"NMS","longName":"Apple Inc.","messageBoardId":"finmb_24937","exchangeTimezoneName":"America\/New_York","exchangeTimezoneShortName":"EDT","gmtOffSetMilliseconds":-14400000,"market":"us_market","esgPopulated":false,"marketState":"POST","shortName":"Apple Inc.","displayName":"Apple","symbol":"AAPL"}';
        $stockQuoteFactory = new StockQuoteFactory($this->createMock(LoggerInterface::class));
        $stockQuote = $stockQuoteFactory->create($json);

        self::assertSame('AAPL', $stockQuote->symbol);
        self::assertSame('en-US', $stockQuote->language);
        self::assertSame('US', $stockQuote->region);
        self::assertSame('EQUITY', $stockQuote->quoteType);
        self::assertSame('Nasdaq Real Time Price', $stockQuote->quoteSourceName);
        self::assertTrue($stockQuote->triggerable);
        self::assertSame('USD', $stockQuote->currency);
        self::assertSame('Apple Inc.', $stockQuote->shortName);
        self::assertSame('POST', $stockQuote->marketState);
        self::assertSame('NMS', $stockQuote->exchange);
        self::assertSame('Apple Inc.', $stockQuote->longName);
        self::assertSame('finmb_24937', $stockQuote->messageBoardId);
        self::assertSame('America/New_York', $stockQuote->exchangeTimezoneName);
        self::assertSame('EDT', $stockQuote->exchangeTimezoneShortName);
        self::assertSame(-14400000, $stockQuote->gmtOffSetMilliseconds);
        self::assertSame('us_market', $stockQuote->market);
        self::assertFalse($stockQuote->esgPopulated);
        self::assertSame(5.61, $stockQuote->epsTrailingTwelveMonths);
        self::assertSame(6.12, $stockQuote->epsForward);
        self::assertSame(5.73, $stockQuote->epsCurrentYear);
        self::assertSame(26.438046, $stockQuote->priceEpsCurrentYear);
        self::assertSame(16406400000, $stockQuote->sharesOutstanding);
        self::assertSame(3.841, $stockQuote->bookValue);
        self::assertSame(145.70555, $stockQuote->fiftyDayAverage);
        self::assertSame(5.7844543, $stockQuote->fiftyDayAverageChange);
        self::assertSame(0.039699614, $stockQuote->fiftyDayAverageChangePercent);
        self::assertSame(140.34676, $stockQuote->twoHundredDayAverage);
        self::assertSame(11.1432495, $stockQuote->twoHundredDayAverageChange);
        self::assertSame(0.079397984, $stockQuote->twoHundredDayAverageChangePercent);
        self::assertSame(2485405614080, $stockQuote->marketCap);
        self::assertSame(24.75327, $stockQuote->forwardPE);
        self::assertSame(39.44025, $stockQuote->priceToBook);
        self::assertSame(15, $stockQuote->sourceInterval);
        self::assertSame(0, $stockQuote->exchangeDataDelayedBy);
        self::assertSame('1.9 - Buy', $stockQuote->averageAnalystRating);
        self::assertSame(345479400000, $stockQuote->firstTradeDateMilliseconds);
        self::assertSame(2, $stockQuote->priceHint);
        self::assertSame(1.4700012, $stockQuote->regularMarketChange);
        self::assertSame(0.9798701, $stockQuote->regularMarketChangePercent);
        self::assertSame('2021-11-03T20:00:03+00:00', $stockQuote->regularMarketTime?->toAtomString());
        self::assertSame(151.49, $stockQuote->regularMarketPrice);
        self::assertSame(151.97, $stockQuote->regularMarketDayHigh);
        self::assertSame('149.83 - 151.97', $stockQuote->regularMarketDayRange);
        self::assertSame(149.83, $stockQuote->regularMarketDayLow);
        self::assertSame(51035964, $stockQuote->regularMarketVolume);
        self::assertSame(150.02, $stockQuote->regularMarketPreviousClose);
        self::assertSame(-0.039615035, $stockQuote->postMarketChangePercent);
        self::assertSame('2021-11-03T20:51:49+00:00', $stockQuote->postMarketTime?->toAtomString());
        self::assertSame(151.43, $stockQuote->postMarketPrice);
        self::assertSame(-0.060012817, $stockQuote->postMarketChange);
        self::assertSame(151.5, $stockQuote->bid);
        self::assertSame(151.51, $stockQuote->ask);
        self::assertSame(11, $stockQuote->bidSize);
        self::assertSame(11, $stockQuote->askSize);
        self::assertSame('NasdaqGS', $stockQuote->fullExchangeName);
        self::assertSame('USD', $stockQuote->financialCurrency);
        self::assertSame(150.39, $stockQuote->regularMarketOpen);
        self::assertSame(75443843, $stockQuote->averageDailyVolume3Month);
        self::assertSame(76612900, $stockQuote->averageDailyVolume10Day);
        self::assertSame(39.140007, $stockQuote->fiftyTwoWeekLowChange);
        self::assertSame(0.34837568, $stockQuote->fiftyTwoWeekLowChangePercent);
        self::assertSame('112.35 - 157.26', $stockQuote->fiftyTwoWeekRange);
        self::assertSame(-5.769989, $stockQuote->fiftyTwoWeekHighChange);
        self::assertSame(-0.03669076, $stockQuote->fiftyTwoWeekHighChangePercent);
        self::assertSame(112.35, $stockQuote->fiftyTwoWeekLow);
        self::assertSame(157.26, $stockQuote->fiftyTwoWeekHigh);
        self::assertSame('2021-11-11T00:00:00+00:00', $stockQuote->dividendDate?->toAtomString());
        self::assertSame('2021-10-28T16:30:00+00:00', $stockQuote->earningsTimestamp?->toAtomString());
        self::assertSame('2022-01-25T10:59:00+00:00', $stockQuote->earningsTimestampStart?->toAtomString());
        self::assertSame('2022-01-31T12:00:00+00:00', $stockQuote->earningsTimestampEnd?->toAtomString());
        self::assertSame(0.85, $stockQuote->trailingAnnualDividendRate);
        self::assertSame(27.003565, $stockQuote->trailingPE);
        self::assertSame(0.0056659114, $stockQuote->trailingAnnualDividendYield);
        self::assertFalse($stockQuote->tradeable);
        self::assertSame('Apple', $stockQuote->displayName);
    }

    public function testCanGetCollection(): void
    {
        $json = '{"quoteResponse":{"result":[{"language":"en-US","region":"US","quoteType":"EQUITY","quoteSourceName":"Nasdaq Real Time Price","triggerable":true,"firstTradeDateMilliseconds":345479400000,"priceHint":2,"postMarketChangePercent":-0.039615035,"postMarketTime":1635972709,"postMarketPrice":151.43,"postMarketChange":-0.060012817,"regularMarketChange":1.4700012,"regularMarketChangePercent":0.9798701,"regularMarketTime":1635969603,"regularMarketPrice":151.49,"regularMarketDayHigh":151.97,"regularMarketDayRange":"149.83 - 151.97","regularMarketDayLow":149.83,"regularMarketVolume":51035964,"regularMarketPreviousClose":150.02,"bid":151.5,"ask":151.51,"bidSize":11,"askSize":11,"fullExchangeName":"NasdaqGS","financialCurrency":"USD","regularMarketOpen":150.39,"averageDailyVolume3Month":75443843,"averageDailyVolume10Day":76612900,"fiftyTwoWeekLowChange":39.140007,"fiftyTwoWeekLowChangePercent":0.34837568,"fiftyTwoWeekRange":"112.35 - 157.26","fiftyTwoWeekHighChange":-5.769989,"fiftyTwoWeekHighChangePercent":-0.03669076,"fiftyTwoWeekLow":112.35,"fiftyTwoWeekHigh":157.26,"dividendDate":1636588800,"earningsTimestamp":1635438600,"earningsTimestampStart":1643108340,"earningsTimestampEnd":1643630400,"trailingAnnualDividendRate":0.85,"trailingPE":27.003565,"trailingAnnualDividendYield":0.0056659114,"epsTrailingTwelveMonths":5.61,"epsForward":6.12,"currency":"USD","epsCurrentYear":5.73,"priceEpsCurrentYear":26.438046,"sharesOutstanding":16406400000,"bookValue":3.841,"fiftyDayAverage":145.70555,"fiftyDayAverageChange":5.7844543,"fiftyDayAverageChangePercent":0.039699614,"twoHundredDayAverage":140.34676,"twoHundredDayAverageChange":11.1432495,"twoHundredDayAverageChangePercent":0.079397984,"marketCap":2485405614080,"forwardPE":24.75327,"priceToBook":39.44025,"sourceInterval":15,"exchangeDataDelayedBy":0,"averageAnalystRating":"1.9 - Buy","tradeable":false,"exchange":"NMS","longName":"Apple Inc.","messageBoardId":"finmb_24937","exchangeTimezoneName":"America\/New_York","exchangeTimezoneShortName":"EDT","gmtOffSetMilliseconds":-14400000,"market":"us_market","esgPopulated":false,"marketState":"POST","shortName":"Apple Inc.","displayName":"Apple","symbol":"AAPL"},{"language":"en-US","region":"US","quoteType":"ETF","quoteSourceName":"Nasdaq Real Time Price","triggerable":true,"firstTradeDateMilliseconds":992611800000,"priceHint":2,"postMarketChangePercent":-0.0831519,"postMarketTime":1635972699,"postMarketPrice":240.32,"postMarketChange":-0.19999695,"regularMarketChange":1.69,"regularMarketChangePercent":0.707617,"regularMarketTime":1635969600,"regularMarketPrice":240.52,"regularMarketDayHigh":240.72,"regularMarketDayRange":"238.295 - 240.72","regularMarketDayLow":238.295,"regularMarketVolume":3662928,"regularMarketPreviousClose":238.83,"bid":240.51,"ask":240.87,"bidSize":8,"askSize":8,"fullExchangeName":"NYSEArca","financialCurrency":"USD","regularMarketOpen":238.69,"averageDailyVolume3Month":3293258,"averageDailyVolume10Day":3140242,"fiftyTwoWeekLowChange":66.83,"fiftyTwoWeekLowChangePercent":0.38476595,"fiftyTwoWeekRange":"173.69 - 240.72","fiftyTwoWeekHighChange":-0.19999695,"fiftyTwoWeekHighChangePercent":-0.00083082815,"fiftyTwoWeekLow":173.69,"fiftyTwoWeekHigh":240.72,"trailingAnnualDividendRate":2.769,"trailingPE":11.419619,"trailingAnnualDividendYield":0.011594021,"ytdReturn":15.25,"trailingThreeMonthReturns":8.13,"trailingThreeMonthNavReturns":8.28,"epsTrailingTwelveMonths":21.062,"currency":"USD","sharesOutstanding":743262976,"bookValue":120.508,"fiftyDayAverage":229.59416,"fiftyDayAverageChange":10.925842,"fiftyDayAverageChangePercent":0.04758763,"twoHundredDayAverage":224.65022,"twoHundredDayAverageChange":15.8697815,"twoHundredDayAverageChangePercent":0.07064218,"marketCap":498771165184,"priceToBook":1.9958841,"sourceInterval":15,"exchangeDataDelayedBy":0,"tradeable":false,"exchange":"PCX","longName":"Vanguard Total Stock Market Index Fund ETF Shares","messageBoardId":"finmb_6184536","exchangeTimezoneName":"America\/New_York","exchangeTimezoneShortName":"EDT","gmtOffSetMilliseconds":-14400000,"market":"us_market","esgPopulated":false,"marketState":"POST","shortName":"Vanguard Total Stock Market ETF","symbol":"VTI"}],"error":null}}';

        $stockQuoteFactory = new StockQuoteFactory($this->createMock(LoggerInterface::class));
        $stockQuoteCollection = $stockQuoteFactory->collection($json);
        $stockQuoteCollection->each(static function (StockQuote $stockQuote): void {
            self::assertContains($stockQuote->symbol, ['AAPL', 'VTI']);
        });
    }

    /**
     * @dataProvider getCases
     */
    public function testIfJsonIncorrectGetException(string $json): void
    {
        self::expectException(UnsupportedResponseDataException::class);

        $stockQuoteFactory = new StockQuoteFactory($this->createMock(LoggerInterface::class));
        $stockQuoteFactory->create($json);
    }

    public static function getCases(): array
    {
        return [
            'MissingSymbol' => [
                'json' => '{"language":"en-US","region":"US","quoteType":"EQUITY","quoteSourceName":"Nasdaq Real Time Price","triggerable":true,"firstTradeDateMilliseconds":345479400000,"priceHint":2,"postMarketChangePercent":-0.039615035,"postMarketTime":1635972709,"postMarketPrice":151.43,"postMarketChange":-0.060012817,"regularMarketChange":1.4700012,"regularMarketChangePercent":0.9798701,"regularMarketTime":1635969603,"regularMarketPrice":151.49,"regularMarketDayHigh":151.97,"regularMarketDayRange":"149.83 - 151.97","regularMarketDayLow":149.83,"regularMarketVolume":51035964,"regularMarketPreviousClose":150.02,"bid":151.5,"ask":151.51,"bidSize":11,"askSize":11,"fullExchangeName":"NasdaqGS","financialCurrency":"USD","regularMarketOpen":150.39,"averageDailyVolume3Month":75443843,"averageDailyVolume10Day":76612900,"fiftyTwoWeekLowChange":39.140007,"fiftyTwoWeekLowChangePercent":0.34837568,"fiftyTwoWeekRange":"112.35 - 157.26","fiftyTwoWeekHighChange":-5.769989,"fiftyTwoWeekHighChangePercent":-0.03669076,"fiftyTwoWeekLow":112.35,"fiftyTwoWeekHigh":157.26,"dividendDate":1636588800,"earningsTimestamp":1635438600,"earningsTimestampStart":1643108340,"earningsTimestampEnd":1643630400,"trailingAnnualDividendRate":0.85,"trailingPE":27.003565,"trailingAnnualDividendYield":0.0056659114,"epsTrailingTwelveMonths":5.61,"epsForward":6.12,"currency":"USD","epsCurrentYear":5.73,"priceEpsCurrentYear":26.438046,"sharesOutstanding":16406400000,"bookValue":3.841,"fiftyDayAverage":145.70555,"fiftyDayAverageChange":5.7844543,"fiftyDayAverageChangePercent":0.039699614,"twoHundredDayAverage":140.34676,"twoHundredDayAverageChange":11.1432495,"twoHundredDayAverageChangePercent":0.079397984,"marketCap":2485405614080,"forwardPE":24.75327,"priceToBook":39.44025,"sourceInterval":15,"exchangeDataDelayedBy":0,"averageAnalystRating":"1.9 - Buy","tradeable":false,"exchange":"NMS","longName":"Apple Inc.","messageBoardId":"finmb_24937","exchangeTimezoneName":"America\/New_York","exchangeTimezoneShortName":"EDT","gmtOffSetMilliseconds":-14400000,"market":"us_market","esgPopulated":false,"marketState":"POST","shortName":"Apple Inc.","displayName":"Apple"}',
            ],
            'MissingLanguage' => [
                'json' => '{"region":"US","quoteType":"EQUITY","quoteSourceName":"Nasdaq Real Time Price","triggerable":true,"firstTradeDateMilliseconds":345479400000,"priceHint":2,"postMarketChangePercent":-0.039615035,"postMarketTime":1635972709,"postMarketPrice":151.43,"postMarketChange":-0.060012817,"regularMarketChange":1.4700012,"regularMarketChangePercent":0.9798701,"regularMarketTime":1635969603,"regularMarketPrice":151.49,"regularMarketDayHigh":151.97,"regularMarketDayRange":"149.83 - 151.97","regularMarketDayLow":149.83,"regularMarketVolume":51035964,"regularMarketPreviousClose":150.02,"bid":151.5,"ask":151.51,"bidSize":11,"askSize":11,"fullExchangeName":"NasdaqGS","financialCurrency":"USD","regularMarketOpen":150.39,"averageDailyVolume3Month":75443843,"averageDailyVolume10Day":76612900,"fiftyTwoWeekLowChange":39.140007,"fiftyTwoWeekLowChangePercent":0.34837568,"fiftyTwoWeekRange":"112.35 - 157.26","fiftyTwoWeekHighChange":-5.769989,"fiftyTwoWeekHighChangePercent":-0.03669076,"fiftyTwoWeekLow":112.35,"fiftyTwoWeekHigh":157.26,"dividendDate":1636588800,"earningsTimestamp":1635438600,"earningsTimestampStart":1643108340,"earningsTimestampEnd":1643630400,"trailingAnnualDividendRate":0.85,"trailingPE":27.003565,"trailingAnnualDividendYield":0.0056659114,"epsTrailingTwelveMonths":5.61,"epsForward":6.12,"currency":"USD","epsCurrentYear":5.73,"priceEpsCurrentYear":26.438046,"sharesOutstanding":16406400000,"bookValue":3.841,"fiftyDayAverage":145.70555,"fiftyDayAverageChange":5.7844543,"fiftyDayAverageChangePercent":0.039699614,"twoHundredDayAverage":140.34676,"twoHundredDayAverageChange":11.1432495,"twoHundredDayAverageChangePercent":0.079397984,"marketCap":2485405614080,"forwardPE":24.75327,"priceToBook":39.44025,"sourceInterval":15,"exchangeDataDelayedBy":0,"averageAnalystRating":"1.9 - Buy","tradeable":false,"exchange":"NMS","longName":"Apple Inc.","messageBoardId":"finmb_24937","exchangeTimezoneName":"America\/New_York","exchangeTimezoneShortName":"EDT","gmtOffSetMilliseconds":-14400000,"market":"us_market","esgPopulated":false,"marketState":"POST","shortName":"Apple Inc.","displayName":"Apple","symbol":"AAPL"}',
            ],
            'MissingRegion' => [
                'json' => '{"language":"en-US","quoteType":"EQUITY","quoteSourceName":"Nasdaq Real Time Price","triggerable":true,"firstTradeDateMilliseconds":345479400000,"priceHint":2,"postMarketChangePercent":-0.039615035,"postMarketTime":1635972709,"postMarketPrice":151.43,"postMarketChange":-0.060012817,"regularMarketChange":1.4700012,"regularMarketChangePercent":0.9798701,"regularMarketTime":1635969603,"regularMarketPrice":151.49,"regularMarketDayHigh":151.97,"regularMarketDayRange":"149.83 - 151.97","regularMarketDayLow":149.83,"regularMarketVolume":51035964,"regularMarketPreviousClose":150.02,"bid":151.5,"ask":151.51,"bidSize":11,"askSize":11,"fullExchangeName":"NasdaqGS","financialCurrency":"USD","regularMarketOpen":150.39,"averageDailyVolume3Month":75443843,"averageDailyVolume10Day":76612900,"fiftyTwoWeekLowChange":39.140007,"fiftyTwoWeekLowChangePercent":0.34837568,"fiftyTwoWeekRange":"112.35 - 157.26","fiftyTwoWeekHighChange":-5.769989,"fiftyTwoWeekHighChangePercent":-0.03669076,"fiftyTwoWeekLow":112.35,"fiftyTwoWeekHigh":157.26,"dividendDate":1636588800,"earningsTimestamp":1635438600,"earningsTimestampStart":1643108340,"earningsTimestampEnd":1643630400,"trailingAnnualDividendRate":0.85,"trailingPE":27.003565,"trailingAnnualDividendYield":0.0056659114,"epsTrailingTwelveMonths":5.61,"epsForward":6.12,"currency":"USD","epsCurrentYear":5.73,"priceEpsCurrentYear":26.438046,"sharesOutstanding":16406400000,"bookValue":3.841,"fiftyDayAverage":145.70555,"fiftyDayAverageChange":5.7844543,"fiftyDayAverageChangePercent":0.039699614,"twoHundredDayAverage":140.34676,"twoHundredDayAverageChange":11.1432495,"twoHundredDayAverageChangePercent":0.079397984,"marketCap":2485405614080,"forwardPE":24.75327,"priceToBook":39.44025,"sourceInterval":15,"exchangeDataDelayedBy":0,"averageAnalystRating":"1.9 - Buy","tradeable":false,"exchange":"NMS","longName":"Apple Inc.","messageBoardId":"finmb_24937","exchangeTimezoneName":"America\/New_York","exchangeTimezoneShortName":"EDT","gmtOffSetMilliseconds":-14400000,"market":"us_market","esgPopulated":false,"marketState":"POST","shortName":"Apple Inc.","displayName":"Apple","symbol":"AAPL"}',
            ],
        ];
    }
}
