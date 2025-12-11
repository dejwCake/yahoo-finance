<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums;

use DejwCake\YahooFinance\Models\Enums\Traits\EnumAsArrayTrait;
use DejwCake\YahooFinance\Models\Enums\Traits\EnumForSelectTrait;

enum Region: string
{
    use EnumForSelectTrait;
    use EnumAsArrayTrait;

    case US = 'US';
    case AU = 'AU';
    case CA = 'CA';
    case FR = 'FR';
    case DE = 'DE';
    case HK = 'HK';
    case IT = 'IT';
    case ES = 'ES';
    case GB = 'GB';
    case IN = 'IN';
}
