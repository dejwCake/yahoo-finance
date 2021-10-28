<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums\Traits;

trait EnumForSelectTrait
{
    public static function getForSelect(): array
    {
        $select = [];
        if (method_exists(self::class, 'all')) {
            foreach (self::all() as $value) {
                $select[] = [
                    'label' => __($value),
                    'value' => $value,
                ];
            }
        }

        return $select;
    }
}
