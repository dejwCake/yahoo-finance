<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums\Traits;

use BackedEnum;

use function call_user_func;
use function function_exists;

trait EnumAsArrayTrait
{
    public function asArray(): array
    {
        assert($this instanceof BackedEnum);
        $value = $this->value;
        $label = function_exists('__') ? call_user_func('__', $value) : $value;

        return [
            'label' => $label,
            'value' => $value,
        ];
    }
}
