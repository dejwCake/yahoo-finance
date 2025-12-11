<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels;

use Carbon\CarbonInterface;
use DejwCake\YahooFinance\ApiClient\Models\ResponseModel as ResponseModelInterface;
use Illuminate\Support\Collection;

readonly class StockHistory implements ResponseModelInterface
{
    public function __construct(
        public string $symbol,
        public ?float $previousClose,
        public ?CarbonInterface $start,
        public ?CarbonInterface $end,
        public ?float $chartPreviousClose,
        public ?int $dataGranularity,
        public Collection $closeValues,
    ) {
    }
}
