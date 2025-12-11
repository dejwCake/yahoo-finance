<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models;

use Carbon\CarbonInterface;

readonly class CloseValue
{
    public function __construct(public CarbonInterface $date, public float $value)
    {
    }
}
