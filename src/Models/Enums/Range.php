<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums;

use DejwCake\YahooFinance\Models\Enums\Traits\EnumAsArrayTrait;
use DejwCake\YahooFinance\Models\Enums\Traits\EnumForSelectTrait;
use MyCLabs\Enum\Enum;

/**
 * @method static Range DAY_1()
 * @method static Range DAYS_5()
 * @method static Range MONTH_1()
 * @method static Range MONTHS_3()
 * @method static Range MONTHS_6()
 * @method static Range YEAR_1()
 * @method static Range YEARS_5()
 * @method static Range MAX()
 */
class Range extends Enum
{
    use EnumAsArrayTrait;
    use EnumForSelectTrait;

    private const DAY_1 = '1d';
    private const DAYS_5 = '5d';
    private const MONTH_1 = '1mo';
    private const MONTHS_3 = '3mo';
    private const MONTHS_6 = '6mo';
    private const YEAR_1 = '1y';
    private const YEARS_5 = '5y';
    private const MAX = 'max';

    public static function all(): array
    {
        return [
            self::DAY_1()->getValue(),
            self::DAYS_5()->getValue(),
            self::MONTH_1()->getValue(),
            self::MONTHS_3()->getValue(),
            self::MONTHS_6()->getValue(),
            self::YEAR_1()->getValue(),
            self::YEARS_5()->getValue(),
            self::MAX()->getValue(),
        ];
    }
}
