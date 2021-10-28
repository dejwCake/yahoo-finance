<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Tests\Unit\Models\RequestModels;

use DejwCake\YahooFinance\Models\Enums\Interval;
use DejwCake\YahooFinance\Models\Enums\Range;
use DejwCake\YahooFinance\Models\RequestModels\GetStockHistoryRequest;
use PHPUnit\Framework\TestCase;

class GetStockHistoryRequestTest extends TestCase
{
    public function testCanGetSymbolsAsString(): void
    {
        $getStockHistoryRequest = new GetStockHistoryRequest(['ABC', 'DEF', 'GHI', 'JKL']);

        $this->assertSame('ABC,DEF,GHI,JKL', $getStockHistoryRequest->getSymbolsAsString());
    }

    public function testCanGetJson(): void
    {
        $getStockHistoryRequest = new GetStockHistoryRequest(
            ['ABC', 'DEF', 'GHI', 'JKL'],
            Interval::MONTH_1(),
            Range::DAY_1(),
        );

        $this->assertSame(
            '{"symbols":["ABC","DEF","GHI","JKL"],"interval":"1mo","range":"1d"}',
            json_encode($getStockHistoryRequest, JSON_THROW_ON_ERROR),
        );
    }
}
