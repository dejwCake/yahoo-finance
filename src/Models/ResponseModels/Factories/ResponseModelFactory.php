<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels\Factories;

use Carbon\Carbon;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnsupportedResponseDataException;

abstract class ResponseModelFactory
{
    protected static function validateRequired(array $data, array $requiredFields = [],): void
    {
        foreach ($requiredFields as $requiredField) {
            if (!isset($data[$requiredField])) {
                throw new UnsupportedResponseDataException(sprintf('Required field "%s" missing', $requiredField));
            }
        }
    }

    protected static function castCarbon(array $data, array $carbonCasts): array
    {
        foreach ($carbonCasts as $cast) {
            if (isset($data[$cast])) {
                $data[$cast] = Carbon::createFromTimestamp($data[$cast]);
            }
        }

        return $data;
    }
}
