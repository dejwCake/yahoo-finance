<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Tests\Functional;

use DejwCake\YahooFinance\Models\Enums\Interval;
use DejwCake\YahooFinance\Models\Enums\Lang;
use DejwCake\YahooFinance\Models\Enums\Range;
use DejwCake\YahooFinance\Models\Enums\Region;
use DejwCake\YahooFinance\Models\RequestModels\GetStockHistoryRequest;
use DejwCake\YahooFinance\Models\RequestModels\GetStockQuoteRequest;
use DejwCake\YahooFinance\YahooFinanceClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

// phpcs:disable SlevomatCodingStandard.Files.LineLength.LineTooLong
class YahooFinanceClientTest extends TestCase
{
    private MockObject|ClientInterface $httpClient;
    private MockObject|ResponseInterface $response;
    private YahooFinanceClient $yahooFinanceClient;

    public function setUp(): void
    {
        parent::setUp();

        $this->response = $this->createMock(ResponseInterface::class);
        $this->response->method('hasHeader')
            ->willReturn(true);
        $this->response->method('getHeader')
            ->willReturn(['application/json']);
        $this->response->method('getStatusCode')
            ->willReturn(200);

        $this->httpClient = $this->createMock(Client::class);
        $this->yahooFinanceClient = YahooFinanceClient::create(
            $this->httpClient,
            $this->createMock(LoggerInterface::class),
        );
    }

    public function testCanGetStockHistory(): void
    {
        $this->response->method('getBody')
            ->willReturn(
                Utils::streamFor(
                    '{"AAPL":{"end":null,"start":null,"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364803],"previousClose":null,"chartPreviousClose":145.37,"symbol":"AAPL","close":[141.91,142.83,141.5,142.65,139.14,141.11,142,143.29,142.9,142.81,141.51,140.91,143.76,144.84,146.55,148.76,149.26,149.48,148.69,148.64,149.32,148.85],"dataGranularity":300},"VTI":{"end":null,"start":null,"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364800],"previousClose":null,"chartPreviousClose":229.14,"symbol":"VTI","close":[224.34,224.49,222.06,225.12,221.73,223.8,224.73,226.89,226.39,224.76,224.6,225.62,229.37,230.73,231.57,233.26,234.17,234.81,234.36,235.8,235.71,234.1],"dataGranularity":300}}',
                ),
            );
        $this->httpClient->method('sendRequest')
            ->willReturn($this->response);

        $getStockHistoryRequest = new GetStockHistoryRequest(['AAPL', 'VTI'], Interval::DAY_1, Range::MONTH_1);
        $stockHistoryCollection = $this->yahooFinanceClient->getStockHistory($getStockHistoryRequest);

        $this->assertInstanceOf(Collection::class, $stockHistoryCollection);
    }

    public function testCanGetStockQuote(): void
    {
        $this->response->method('getBody')
            ->willReturn(
                Utils::streamFor(
                    '{"quoteResponse":{"result":[{"language":"en-US","region":"US","quoteType":"EQUITY","quoteSourceName":"Nasdaq Real Time Price","triggerable":true,"firstTradeDateMilliseconds":345479400000,"priceHint":2,"postMarketChangePercent":-0.039615035,"postMarketTime":1635972709,"postMarketPrice":151.43,"postMarketChange":-0.060012817,"regularMarketChange":1.4700012,"regularMarketChangePercent":0.9798701,"regularMarketTime":1635969603,"regularMarketPrice":151.49,"regularMarketDayHigh":151.97,"regularMarketDayRange":"149.83 - 151.97","regularMarketDayLow":149.83,"regularMarketVolume":51035964,"regularMarketPreviousClose":150.02,"bid":151.5,"ask":151.51,"bidSize":11,"askSize":11,"fullExchangeName":"NasdaqGS","financialCurrency":"USD","regularMarketOpen":150.39,"averageDailyVolume3Month":75443843,"averageDailyVolume10Day":76612900,"fiftyTwoWeekLowChange":39.140007,"fiftyTwoWeekLowChangePercent":0.34837568,"fiftyTwoWeekRange":"112.35 - 157.26","fiftyTwoWeekHighChange":-5.769989,"fiftyTwoWeekHighChangePercent":-0.03669076,"fiftyTwoWeekLow":112.35,"fiftyTwoWeekHigh":157.26,"dividendDate":1636588800,"earningsTimestamp":1635438600,"earningsTimestampStart":1643108340,"earningsTimestampEnd":1643630400,"trailingAnnualDividendRate":0.85,"trailingPE":27.003565,"trailingAnnualDividendYield":0.0056659114,"epsTrailingTwelveMonths":5.61,"epsForward":6.12,"currency":"USD","epsCurrentYear":5.73,"priceEpsCurrentYear":26.438046,"sharesOutstanding":16406400000,"bookValue":3.841,"fiftyDayAverage":145.70555,"fiftyDayAverageChange":5.7844543,"fiftyDayAverageChangePercent":0.039699614,"twoHundredDayAverage":140.34676,"twoHundredDayAverageChange":11.1432495,"twoHundredDayAverageChangePercent":0.079397984,"marketCap":2485405614080,"forwardPE":24.75327,"priceToBook":39.44025,"sourceInterval":15,"exchangeDataDelayedBy":0,"averageAnalystRating":"1.9 - Buy","tradeable":false,"exchange":"NMS","longName":"Apple Inc.","messageBoardId":"finmb_24937","exchangeTimezoneName":"America\/New_York","exchangeTimezoneShortName":"EDT","gmtOffSetMilliseconds":-14400000,"market":"us_market","esgPopulated":false,"marketState":"POST","shortName":"Apple Inc.","displayName":"Apple","symbol":"AAPL"},{"language":"en-US","region":"US","quoteType":"ETF","quoteSourceName":"Nasdaq Real Time Price","triggerable":true,"firstTradeDateMilliseconds":992611800000,"priceHint":2,"postMarketChangePercent":-0.0831519,"postMarketTime":1635972699,"postMarketPrice":240.32,"postMarketChange":-0.19999695,"regularMarketChange":1.69,"regularMarketChangePercent":0.707617,"regularMarketTime":1635969600,"regularMarketPrice":240.52,"regularMarketDayHigh":240.72,"regularMarketDayRange":"238.295 - 240.72","regularMarketDayLow":238.295,"regularMarketVolume":3662928,"regularMarketPreviousClose":238.83,"bid":240.51,"ask":240.87,"bidSize":8,"askSize":8,"fullExchangeName":"NYSEArca","financialCurrency":"USD","regularMarketOpen":238.69,"averageDailyVolume3Month":3293258,"averageDailyVolume10Day":3140242,"fiftyTwoWeekLowChange":66.83,"fiftyTwoWeekLowChangePercent":0.38476595,"fiftyTwoWeekRange":"173.69 - 240.72","fiftyTwoWeekHighChange":-0.19999695,"fiftyTwoWeekHighChangePercent":-0.00083082815,"fiftyTwoWeekLow":173.69,"fiftyTwoWeekHigh":240.72,"trailingAnnualDividendRate":2.769,"trailingPE":11.419619,"trailingAnnualDividendYield":0.011594021,"ytdReturn":15.25,"trailingThreeMonthReturns":8.13,"trailingThreeMonthNavReturns":8.28,"epsTrailingTwelveMonths":21.062,"currency":"USD","sharesOutstanding":743262976,"bookValue":120.508,"fiftyDayAverage":229.59416,"fiftyDayAverageChange":10.925842,"fiftyDayAverageChangePercent":0.04758763,"twoHundredDayAverage":224.65022,"twoHundredDayAverageChange":15.8697815,"twoHundredDayAverageChangePercent":0.07064218,"marketCap":498771165184,"priceToBook":1.9958841,"sourceInterval":15,"exchangeDataDelayedBy":0,"tradeable":false,"exchange":"PCX","longName":"Vanguard Total Stock Market Index Fund ETF Shares","messageBoardId":"finmb_6184536","exchangeTimezoneName":"America\/New_York","exchangeTimezoneShortName":"EDT","gmtOffSetMilliseconds":-14400000,"market":"us_market","esgPopulated":false,"marketState":"POST","shortName":"Vanguard Total Stock Market ETF","symbol":"VTI"}],"error":null}}',
                ),
            );
        $this->httpClient->method('sendRequest')
            ->willReturn($this->response);

        $getStockQuoteRequest = new GetStockQuoteRequest(['AAPL', 'VTI'], Region::US, Lang::EN);
        $stockQuoteCollection = $this->yahooFinanceClient->getStockQuote($getStockQuoteRequest);

        $this->assertInstanceOf(Collection::class, $stockQuoteCollection);
    }
}
