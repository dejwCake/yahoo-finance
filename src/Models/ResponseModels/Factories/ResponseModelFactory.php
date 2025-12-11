<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels\Factories;

use Carbon\CarbonImmutable;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnsupportedResponseDataException;

abstract readonly class ResponseModelFactory
{
    protected function validateRequired(array $data, array $requiredFields = [],): void
    {
        foreach ($requiredFields as $requiredField) {
            if (!isset($data[$requiredField])) {
                throw new UnsupportedResponseDataException(sprintf('Required field "%s" missing', $requiredField));
            }
        }
    }

    protected function castCarbon(array $data, array $carbonCasts): array
    {
        foreach ($carbonCasts as $cast) {
            if (isset($data[$cast])) {
                $data[$cast] = CarbonImmutable::createFromTimestamp($data[$cast]);
            }
        }

        return $data;
    }
}
