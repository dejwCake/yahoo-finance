<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Tests\Unit\Models\RequestModels;

use DejwCake\YahooFinance\Models\Enums\Lang;
use DejwCake\YahooFinance\Models\Enums\Region;
use DejwCake\YahooFinance\Models\RequestModels\GetStockQuoteRequest;
use PHPUnit\Framework\TestCase;

class GetStockQuoteRequestTest extends TestCase
{
    public function testCanGetSymbolsAsString(): void
    {
        $getStockQuoteRequest = new GetStockQuoteRequest(['ABC', 'DEF', 'GHI', 'JKL']);

        self::assertSame('ABC,DEF,GHI,JKL', $getStockQuoteRequest->getSymbolsAsString());
    }

    public function testCanGetJson(): void
    {
        $getStockQuoteRequest = new GetStockQuoteRequest(
            ['ABC', 'DEF', 'GHI', 'JKL'],
            Region::US,
            Lang::EN,
        );

        self::assertSame(
            '{"symbols":["ABC","DEF","GHI","JKL"],"region":"US","lang":"en"}',
            json_encode($getStockQuoteRequest, JSON_THROW_ON_ERROR),
        );
    }
}
