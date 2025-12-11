<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums;

use DejwCake\YahooFinance\Models\Enums\Traits\EnumAsArrayTrait;
use DejwCake\YahooFinance\Models\Enums\Traits\EnumForSelectTrait;

enum Interval: string
{
    use EnumForSelectTrait;
    use EnumAsArrayTrait;

    case MINUTE_1 = '1m';
    case MINUTES_5 = '5m';
    case MINUTES_15 = '15m';
    case DAY_1 = '1d';
    case WEEK_1 = '1wk';
    case MONTH_1 = '1mo';
}
