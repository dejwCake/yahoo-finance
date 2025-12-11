<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums\Traits;

use UnitEnum;

use function call_user_func;
use function function_exists;
use function method_exists;

trait EnumForSelectTrait
{
    /**
     * @return array<int, array{label:string,value:string}>
     */
    public static function getForSelect(): array
    {
        $select = [];

        // Prefer native enum cases() if available
        if (method_exists(static::class, 'cases')) {
            $cases = call_user_func([static::class, 'cases']);
            foreach ($cases as $case) {
                assert($case instanceof UnitEnum);
                $value = property_exists($case, 'value') ? $case->value : $case->name;
                $label = function_exists('__') ? call_user_func('__', $value) : $value;
                $select[] = [
                    'label' => $label,
                    'value' => $value,
                ];
            }
        }

        return $select;
    }
}
