<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums;

use DejwCake\YahooFinance\Models\Enums\Traits\EnumAsArrayTrait;
use DejwCake\YahooFinance\Models\Enums\Traits\EnumForSelectTrait;
use MyCLabs\Enum\Enum;

/**
 * @method static Interval MINUTE_1()
 * @method static Interval MINUTES_5()
 * @method static Interval MINUTES_15()
 * @method static Interval DAY_1()
 * @method static Interval WEEK_1()
 * @method static Interval MONTH_1()
 */
class Interval extends Enum
{
    use EnumAsArrayTrait;
    use EnumForSelectTrait;

    private const MINUTE_1 = '1';
    private const MINUTES_5 = '5m';
    private const MINUTES_15 = '15m';
    private const DAY_1 = '1d';
    private const WEEK_1 = '1wk';
    private const MONTH_1 = '1mo';

    public static function all(): array
    {
        return [
            self::MINUTE_1()->getValue(),
            self::MINUTES_5()->getValue(),
            self::MINUTES_15()->getValue(),
            self::DAY_1()->getValue(),
            self::WEEK_1()->getValue(),
            self::MONTH_1()->getValue(),
        ];
    }
}
