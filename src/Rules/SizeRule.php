<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Rules;

use Illuminate\Contracts\Validation\Rule;

use function class_basename;
use function count;

class SizeRule implements Rule
{
    public function __construct(private int $size)
    {
    }

    public function __toString(): string
    {
        return class_basename($this);
    }

    /**
     * @inheritDoc
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function passes($attribute, $value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        return count($value) === $this->size;
    }

    public function message(): string
    {
        return "Does not have correct size.";
    }
}
