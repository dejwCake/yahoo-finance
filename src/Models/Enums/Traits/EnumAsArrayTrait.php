<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\Enums\Traits;

trait EnumAsArrayTrait
{
    public function asArray(): array
    {
        return [
            'label' => __($this->getValue()),
            'value' => $this->getValue(),
        ];
    }
}
