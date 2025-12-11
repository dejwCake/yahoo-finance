<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\RequestModels;

use DejwCake\YahooFinance\ApiClient\Models\RequestModel;
use DejwCake\YahooFinance\Models\Enums\Interval;
use DejwCake\YahooFinance\Models\Enums\Range;

final readonly class GetStockHistoryRequest implements RequestModel
{
    public function __construct(
        public array $symbols,
        public Interval $interval = Interval::DAY_1,
        public Range $range = Range::MONTH_1,
    ) {
    }

    public function getSymbolsAsString(): string
    {
        return implode(',', $this->symbols);
    }

    public function jsonSerialize(): array
    {
        return [
            'symbols' => $this->symbols,
            'interval' => $this->interval->value,
            'range' => $this->range->value,
        ];
    }
}
