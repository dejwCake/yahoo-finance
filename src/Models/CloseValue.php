<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models;

use Carbon\Carbon;

class CloseValue
{
    public function __construct(private readonly Carbon $date, private readonly float $value)
    {
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
