<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels;

use Carbon\Carbon;
use DejwCake\YahooFinance\ApiClient\Models\ResponseModel as ResponseModelInterface;
use Illuminate\Support\Collection;

class StockHistory implements ResponseModelInterface
{
    public function __construct(
        private readonly string $symbol,
        private readonly ?float $previousClose,
        private readonly ?Carbon $start,
        private readonly ?Carbon $end,
        private readonly ?float $chartPreviousClose,
        private readonly ?int $dataGranularity,
        private readonly Collection $closeValues,
    ) {
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPreviousClose(): ?float
    {
        return $this->previousClose;
    }

    public function getStart(): ?Carbon
    {
        return $this->start;
    }

    public function getEnd(): ?Carbon
    {
        return $this->end;
    }

    public function getChartPreviousClose(): ?float
    {
        return $this->chartPreviousClose;
    }

    public function getDataGranularity(): ?int
    {
        return $this->dataGranularity;
    }

    public function getCloseValues(): Collection
    {
        return $this->closeValues;
    }
}
