<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Tests\Unit\Models\ResponseModels\Factories;

use DejwCake\YahooFinance\ApiClient\Exceptions\UnsupportedResponseDataException;
use DejwCake\YahooFinance\Models\CloseValue;
use DejwCake\YahooFinance\Models\ResponseModels\Factories\StockHistoryFactory;
use DejwCake\YahooFinance\Models\ResponseModels\StockHistory;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

// phpcs:disable SlevomatCodingStandard.Files.LineLength.LineTooLong
class StockHistoryFactoryTest extends TestCase
{
    public function testCanGetFromJson(): void
    {
        $json = '{"end":null,"start":null,"previousClose":null,"chartPreviousClose":145.37,"symbol":"AAPL","dataGranularity":300,"close":[141.91,142.83,141.5,142.65,139.14,141.11,142,143.29,142.9,142.81,141.51,140.91,143.76,144.84,146.55,148.76,149.26,149.48,148.69,148.64,149.32,148.85],"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364803]}';
        $stockHistoryFactory = new StockHistoryFactory($this->createMock(LoggerInterface::class));
        $stockHistory = $stockHistoryFactory->create($json);
        $this->assertSame('AAPL', $stockHistory->getSymbol());
        $this->assertNull($stockHistory->getPreviousClose());
        $this->assertNull($stockHistory->getStart());
        $this->assertNull($stockHistory->getEnd());
        $this->assertSame(145.37, $stockHistory->getChartPreviousClose());
        $this->assertSame(300, $stockHistory->getDataGranularity());
        $firstCloseValue = $stockHistory->getCloseValues()->sortBy(
            static fn (CloseValue $closeValue) => $closeValue->getDate()->toIso8601String(),
        )->first();
        $this->assertSame(141.91, $firstCloseValue->getValue());
    }

    public function testCanGetCollection(): void
    {
        $json = '{"AAPL":{"end":null,"start":null,"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364803],"previousClose":null,"chartPreviousClose":145.37,"symbol":"AAPL","close":[141.91,142.83,141.5,142.65,139.14,141.11,142,143.29,142.9,142.81,141.51,140.91,143.76,144.84,146.55,148.76,149.26,149.48,148.69,148.64,149.32,148.85],"dataGranularity":300},"VTI":{"end":null,"start":null,"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364800],"previousClose":null,"chartPreviousClose":229.14,"symbol":"VTI","close":[224.34,224.49,222.06,225.12,221.73,223.8,224.73,226.89,226.39,224.76,224.6,225.62,229.37,230.73,231.57,233.26,234.17,234.81,234.36,235.8,235.71,234.1],"dataGranularity":300}}';
        $stockHistoryFactory = new StockHistoryFactory($this->createMock(LoggerInterface::class));
        $stockHistoryCollection = $stockHistoryFactory->collection($json);
        $stockHistoryCollection->each(function (StockHistory $stockHistory): void {
            $this->assertContains($stockHistory->getSymbol(), ['AAPL', 'VTI']);
        });
    }

    /**
     * @dataProvider getCases
     */
    public function testIfJsonIncorrectGetException(string $json): void
    {
        $this->expectException(UnsupportedResponseDataException::class);

        $stockHistoryFactory = new StockHistoryFactory($this->createMock(LoggerInterface::class));
        $stockHistoryFactory->create($json);
    }

    public static function getCases(): array
    {
        return [
            'MissingSymbol' => [
                'json' => '{"end":null,"start":null,"previousClose":null,"chartPreviousClose":145.37,"dataGranularity":300,"close":[141.91,142.83,141.5,142.65,139.14,141.11,142,143.29,142.9,142.81,141.51,140.91,143.76,144.84,146.55,148.76,149.26,149.48,148.69,148.64,149.32,148.85],"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364803]}',
            ],
            'MissingTimestamp' => [
                'json' => '{"end":null,"start":null,"previousClose":null,"chartPreviousClose":145.37,"symbol":"AAPL","dataGranularity":300,"close":[141.91,142.83,141.5,142.65,139.14,141.11,142,143.29,142.9,142.81,141.51,140.91,143.76,144.84,146.55,148.76,149.26,149.48,148.69,148.64,149.32,148.85]}',
            ],
            'MissingClose' => [
                'json' => '{"end":null,"start":null,"previousClose":null,"chartPreviousClose":145.37,"symbol":"AAPL","dataGranularity":300,"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364803]}',
            ],
            'TimestampNotArray' => [
                'json' => '{"end":null,"start":null,"previousClose":null,"chartPreviousClose":145.37,"symbol":"AAPL","dataGranularity":300,"close":[141.91,142.83,141.5,142.65,139.14,141.11,142,143.29,142.9,142.81,141.51,140.91,143.76,144.84,146.55,148.76,149.26,149.48,148.69,148.64,149.32,148.85],"timestamp":1632835800}',
            ],
            'CloseNotArray' => [
                'json' => '{"end":null,"start":null,"previousClose":null,"chartPreviousClose":145.37,"symbol":"AAPL","dataGranularity":300,"close":141.91,"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364803]}',
            ],
            'TimestampAndCloseNotSameLong' => [
                'json' => '{"end":null,"start":null,"previousClose":null,"chartPreviousClose":145.37,"symbol":"AAPL","dataGranularity":300,"close":[141.91,142.83,141.5,142.65,139.14,141.11,142,143.29,142.9,142.81,141.51,140.91,143.76,144.84,146.55,148.76,149.26,149.48,148.69,148.64,149.32],"timestamp":[1632835800,1632922200,1633008600,1633095000,1633354200,1633440600,1633527000,1633613400,1633699800,1633959000,1634045400,1634131800,1634218200,1634304600,1634563800,1634650200,1634736600,1634823000,1634909400,1635168600,1635255000,1635364803]}',
            ],

        ];
    }
}
