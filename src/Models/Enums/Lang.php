<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums;

use DejwCake\YahooFinance\Models\Enums\Traits\EnumAsArrayTrait;
use DejwCake\YahooFinance\Models\Enums\Traits\EnumForSelectTrait;

enum Lang: string
{
    use EnumForSelectTrait;
    use EnumAsArrayTrait;

    case EN = 'en';
    case FR = 'fr';
    case DE = 'de';
    case IT = 'it';
    case ES = 'es';
    case ZH = 'zh';
}
