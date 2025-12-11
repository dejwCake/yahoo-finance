<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums;

use DejwCake\YahooFinance\Models\Enums\Traits\EnumAsArrayTrait;
use DejwCake\YahooFinance\Models\Enums\Traits\EnumForSelectTrait;

enum Range: string
{
    use EnumForSelectTrait;
    use EnumAsArrayTrait;

    case DAY_1 = '1d';
    case DAYS_5 = '5d';
    case MONTH_1 = '1mo';
    case MONTHS_3 = '3mo';
    case MONTHS_6 = '6mo';
    case YEAR_1 = '1y';
    case YEARS_5 = '5y';
    case MAX = 'max';
}
