<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Tests\Unit\EndPoints;

use DejwCake\YahooFinance\ApiClient\Client;
use DejwCake\YahooFinance\ApiClient\Exceptions\InternalServerErrorException;
use DejwCake\YahooFinance\ApiClient\Exceptions\NotFoundException;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedContentTypeException;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedStatusCodeException;
use DejwCake\YahooFinance\EndPoints\GetStockQuote;
use DejwCake\YahooFinance\Models\Enums\Lang;
use DejwCake\YahooFinance\Models\Enums\Region;
use DejwCake\YahooFinance\Models\RequestModels\GetStockQuoteRequest;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;

// phpcs:disable SlevomatCodingStandard.Files.LineLength.LineTooLong
class GetStockQuoteTest extends TestCase
{
    private GetStockQuote $getStockQuote;
    private StreamInterface $body;

    public function setUp(): void
    {
        parent::setUp();

        $getStockQuoteRequest = new GetStockQuoteRequest(['AAPL', 'VTI'], Region::US, Lang::EN);
        $this->getStockQuote = new GetStockQuote($getStockQuoteRequest, $this->createMock(LoggerInterface::class));

        $this->body = Utils::streamFor(
            '{"quoteResponse":{"result":[{"language":"en-US","region":"US","quoteType":"EQUITY","quoteSourceName":"Nasdaq Real Time Price","triggerable":true,"firstTradeDateMilliseconds":345479400000,"priceHint":2,"postMarketChangePercent":-0.039615035,"postMarketTime":1635972709,"postMarketPrice":151.43,"postMarketChange":-0.060012817,"regularMarketChange":1.4700012,"regularMarketChangePercent":0.9798701,"regularMarketTime":1635969603,"regularMarketPrice":151.49,"regularMarketDayHigh":151.97,"regularMarketDayRange":"149.83 - 151.97","regularMarketDayLow":149.83,"regularMarketVolume":51035964,"regularMarketPreviousClose":150.02,"bid":151.5,"ask":151.51,"bidSize":11,"askSize":11,"fullExchangeName":"NasdaqGS","financialCurrency":"USD","regularMarketOpen":150.39,"averageDailyVolume3Month":75443843,"averageDailyVolume10Day":76612900,"fiftyTwoWeekLowChange":39.140007,"fiftyTwoWeekLowChangePercent":0.34837568,"fiftyTwoWeekRange":"112.35 - 157.26","fiftyTwoWeekHighChange":-5.769989,"fiftyTwoWeekHighChangePercent":-0.03669076,"fiftyTwoWeekLow":112.35,"fiftyTwoWeekHigh":157.26,"dividendDate":1636588800,"earningsTimestamp":1635438600,"earningsTimestampStart":1643108340,"earningsTimestampEnd":1643630400,"trailingAnnualDividendRate":0.85,"trailingPE":27.003565,"trailingAnnualDividendYield":0.0056659114,"epsTrailingTwelveMonths":5.61,"epsForward":6.12,"currency":"USD","epsCurrentYear":5.73,"priceEpsCurrentYear":26.438046,"sharesOutstanding":16406400000,"bookValue":3.841,"fiftyDayAverage":145.70555,"fiftyDayAverageChange":5.7844543,"fiftyDayAverageChangePercent":0.039699614,"twoHundredDayAverage":140.34676,"twoHundredDayAverageChange":11.1432495,"twoHundredDayAverageChangePercent":0.079397984,"marketCap":2485405614080,"forwardPE":24.75327,"priceToBook":39.44025,"sourceInterval":15,"exchangeDataDelayedBy":0,"averageAnalystRating":"1.9 - Buy","tradeable":false,"exchange":"NMS","longName":"Apple Inc.","messageBoardId":"finmb_24937","exchangeTimezoneName":"America\/New_York","exchangeTimezoneShortName":"EDT","gmtOffSetMilliseconds":-14400000,"market":"us_market","esgPopulated":false,"marketState":"POST","shortName":"Apple Inc.","displayName":"Apple","symbol":"AAPL"},{"language":"en-US","region":"US","quoteType":"ETF","quoteSourceName":"Nasdaq Real Time Price","triggerable":true,"firstTradeDateMilliseconds":992611800000,"priceHint":2,"postMarketChangePercent":-0.0831519,"postMarketTime":1635972699,"postMarketPrice":240.32,"postMarketChange":-0.19999695,"regularMarketChange":1.69,"regularMarketChangePercent":0.707617,"regularMarketTime":1635969600,"regularMarketPrice":240.52,"regularMarketDayHigh":240.72,"regularMarketDayRange":"238.295 - 240.72","regularMarketDayLow":238.295,"regularMarketVolume":3662928,"regularMarketPreviousClose":238.83,"bid":240.51,"ask":240.87,"bidSize":8,"askSize":8,"fullExchangeName":"NYSEArca","financialCurrency":"USD","regularMarketOpen":238.69,"averageDailyVolume3Month":3293258,"averageDailyVolume10Day":3140242,"fiftyTwoWeekLowChange":66.83,"fiftyTwoWeekLowChangePercent":0.38476595,"fiftyTwoWeekRange":"173.69 - 240.72","fiftyTwoWeekHighChange":-0.19999695,"fiftyTwoWeekHighChangePercent":-0.00083082815,"fiftyTwoWeekLow":173.69,"fiftyTwoWeekHigh":240.72,"trailingAnnualDividendRate":2.769,"trailingPE":11.419619,"trailingAnnualDividendYield":0.011594021,"ytdReturn":15.25,"trailingThreeMonthReturns":8.13,"trailingThreeMonthNavReturns":8.28,"epsTrailingTwelveMonths":21.062,"currency":"USD","sharesOutstanding":743262976,"bookValue":120.508,"fiftyDayAverage":229.59416,"fiftyDayAverageChange":10.925842,"fiftyDayAverageChangePercent":0.04758763,"twoHundredDayAverage":224.65022,"twoHundredDayAverageChange":15.8697815,"twoHundredDayAverageChangePercent":0.07064218,"marketCap":498771165184,"priceToBook":1.9958841,"sourceInterval":15,"exchangeDataDelayedBy":0,"tradeable":false,"exchange":"PCX","longName":"Vanguard Total Stock Market Index Fund ETF Shares","messageBoardId":"finmb_6184536","exchangeTimezoneName":"America\/New_York","exchangeTimezoneShortName":"EDT","gmtOffSetMilliseconds":-14400000,"market":"us_market","esgPopulated":false,"marketState":"POST","shortName":"Vanguard Total Stock Market ETF","symbol":"VTI"}],"error":null}}',
        );
    }

    public function testCanGetUri(): void
    {
        $this->assertSame('/v6/finance/quote', $this->getStockQuote->getUri());
    }

    public function testCanGetQueryString(): void
    {
        $this->assertSame('symbols=AAPL%2CVTI&region=US&lang=en', $this->getStockQuote->getQueryString());
    }

    public function testCanParseResponse(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('hasHeader')
            ->willReturn(true);
        $response->method('getHeader')
            ->willReturn(['application/json']);
        $response->method('getStatusCode')
            ->willReturn(200);
        $response->method('getBody')
            ->willReturn($this->body);

        $this->assertInstanceOf(Collection::class, $this->getStockQuote->parseResponse($response));

        $this->assertInstanceOf(
            ResponseInterface::class,
            $this->getStockQuote->parseResponse($response, Client::FETCH_RESPONSE),
        );
    }

    /**
     * @dataProvider getExceptionCases
     */
    public function testCanGetExceptionBasedOnStatusCode(int $code, string $exception): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('hasHeader')
            ->willReturn(true);
        $response->method('getHeader')
            ->willReturn(['application/json']);
        $response->method('getStatusCode')
            ->willReturn($code);
        $response->method('getBody')
            ->willReturn($this->body);

        $this->expectException($exception);

        $this->getStockQuote->parseResponse($response);
    }

    public function testCanGetExceptionOnWrongContentType(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('hasHeader')
            ->willReturn(true);
        $response->method('getHeader')
            ->willReturn(['application/text']);
        $response->method('getStatusCode')
            ->willReturn(200);
        $response->method('getBody')
            ->willReturn($this->body);

        $this->expectException(UnexpectedContentTypeException::class);

        $this->getStockQuote->parseResponse($response);
    }

    public static function getExceptionCases(): array
    {
        return [
            500 => [
                'code' => 500,
                'exception' => InternalServerErrorException::class,
            ],
            404 => [
                'code' => 404,
                'exception' => NotFoundException::class,
            ],
            300 => [
                'code' => 300,
                'exception' => UnexpectedStatusCodeException::class,
            ],
        ];
    }
}
