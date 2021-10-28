<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums;

use DejwCake\YahooFinance\Models\Enums\Traits\EnumAsArrayTrait;
use DejwCake\YahooFinance\Models\Enums\Traits\EnumForSelectTrait;
use MyCLabs\Enum\Enum;

/**
 * @method static Lang EN()
 * @method static Lang FR()
 * @method static Lang DE()
 * @method static Lang IT()
 * @method static Lang ES()
 * @method static Lang ZH()
 */
class Lang extends Enum
{
    use EnumAsArrayTrait;
    use EnumForSelectTrait;

    private const EN = 'en';
    private const FR = 'fr';
    private const DE = 'de';
    private const IT = 'it';
    private const ES = 'es';
    private const ZH = 'zh';

    public static function all(): array
    {
        return [
            self::EN()->getValue(),
            self::FR()->getValue(),
            self::DE()->getValue(),
            self::IT()->getValue(),
            self::ES()->getValue(),
            self::ZH()->getValue(),
        ];
    }
}
