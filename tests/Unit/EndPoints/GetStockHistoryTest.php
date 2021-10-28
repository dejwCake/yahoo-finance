<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Tests\Unit\EndPoints;

use DejwCake\YahooFinance\ApiClient\Client;
use DejwCake\YahooFinance\ApiClient\Exceptions\InternalServerErrorException;
use DejwCake\YahooFinance\ApiClient\Exceptions\NotFoundException;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedContentTypeException;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnexpectedStatusCodeException;
use DejwCake\YahooFinance\EndPoints\GetStockHistory;
use DejwCake\YahooFinance\Models\Enums\Interval;
use DejwCake\YahooFinance\Models\Enums\Range;
use DejwCake\YahooFinance\Models\RequestModels\GetStockHistoryRequest;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

// phpcs:disable SlevomatCodingStandard.Files.LineLength.LineTooLong
class GetStockHistoryTest extends TestCase
{
    private GetStockHistory $getStockHistory;
    private string $body;

    public function setUp(): void
    {
        parent::setUp();

        $getStockHistoryRequest = new GetStockHistoryRequest(['AAPL', 'VTI'], Interval::DAY_1(), Range::MONTH_1());
        $this->getStockHistory = new GetStockHistory($getStockHistoryRequest);

        $this->body = '{"AAPL":{"end":null,"start":null,"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364803],"previousClose":null,"chartPreviousClose":145.37,"symbol":"AAPL","close":[141.91,142.83,141.5,142.65,139.14,141.11,142,143.29,142.9,142.81,141.51,140.91,143.76,144.84,146.55,148.76,149.26,149.48,148.69,148.64,149.32,148.85],"dataGranularity":300},"VTI":{"end":null,"start":null,"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364800],"previousClose":null,"chartPreviousClose":229.14,"symbol":"VTI","close":[224.34,224.49,222.06,225.12,221.73,223.8,224.73,226.89,226.39,224.76,224.6,225.62,229.37,230.73,231.57,233.26,234.17,234.81,234.36,235.8,235.71,234.1],"dataGranularity":300}}';
    }

    public function testCanGetUri(): void
    {
        $this->assertSame('/v8/finance/spark', $this->getStockHistory->getUri());
    }

    public function testCanGetQueryString(): void
    {
        $this->assertSame('symbols=AAPL%2CVTI&interval=1d&range=1mo', $this->getStockHistory->getQueryString());
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

        $this->assertInstanceOf(Collection::class, $this->getStockHistory->parseResponse($response));

        $this->assertInstanceOf(
            ResponseInterface::class,
            $this->getStockHistory->parseResponse($response, Client::FETCH_RESPONSE),
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

        $this->getStockHistory->parseResponse($response);
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

        $this->getStockHistory->parseResponse($response);
    }

    public function getExceptionCases(): array
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
