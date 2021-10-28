<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums;

use DejwCake\YahooFinance\Models\Enums\Traits\EnumAsArrayTrait;
use DejwCake\YahooFinance\Models\Enums\Traits\EnumForSelectTrait;
use MyCLabs\Enum\Enum;

/**
 * @method static Region US()
 * @method static Region AU()
 * @method static Region CA()
 * @method static Region FR()
 * @method static Region DE()
 * @method static Region HK()
 * @method static Region IT()
 * @method static Region ES()
 * @method static Region GB()
 * @method static Region IN()
 */
class Region extends Enum
{
    use EnumAsArrayTrait;
    use EnumForSelectTrait;

    private const US = 'US';
    private const AU = 'AU';
    private const CA = 'CA';
    private const FR = 'FR';
    private const DE = 'DE';
    private const HK = 'HK';
    private const IT = 'IT';
    private const ES = 'ES';
    private const GB = 'GB';
    private const IN = 'IN';

    public static function all(): array
    {
        return [
            self::US()->getValue(),
            self::AU()->getValue(),
            self::CA()->getValue(),
            self::FR()->getValue(),
            self::DE()->getValue(),
            self::HK()->getValue(),
            self::IT()->getValue(),
            self::ES()->getValue(),
            self::GB()->getValue(),
            self::IN()->getValue(),
        ];
    }
}
