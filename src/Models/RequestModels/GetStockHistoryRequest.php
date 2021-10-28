<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\RequestModels;

use DejwCake\YahooFinance\ApiClient\Models\RequestModel;
use DejwCake\YahooFinance\Models\Enums\Interval;
use DejwCake\YahooFinance\Models\Enums\Range;

class GetStockHistoryRequest implements RequestModel
{
    private ?Interval $interval;
    private ?Range $range;

    public function __construct(private array $symbols, ?Interval $interval = null, ?Range $range = null,)
    {
        $this->interval = $interval ?? Interval::DAY_1();
        $this->range = $range ?? Range::MONTH_1();
    }

    public function getSymbols(): array
    {
        return $this->symbols;
    }

    public function setSymbols(array $symbols): GetStockHistoryRequest
    {
        $this->symbols = $symbols;

        return $this;
    }

    public function getSymbolsAsString(): string
    {
        return implode(',', $this->getSymbols());
    }

    public function getInterval(): Interval
    {
        return $this->interval;
    }

    public function setInterval(Interval $interval): GetStockHistoryRequest
    {
        $this->interval = $interval;

        return $this;
    }

    public function getRange(): Range
    {
        return $this->range;
    }

    public function setRange(Range $range): GetStockHistoryRequest
    {
        $this->range = $range;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'symbols' => $this->getSymbols(),
            'interval' => $this->getInterval()->getValue(),
            'range' => $this->getRange()->getValue(),
        ];
    }
}
