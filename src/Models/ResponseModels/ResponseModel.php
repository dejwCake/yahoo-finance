<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels;

use Carbon\Carbon;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnsupportedResponseDataException;
use DejwCake\YahooFinance\Validators\Validator;
use Symfony\Component\VarDumper\VarDumper;

abstract class ResponseModel
{
    protected static function validate(
        array $data,
        array $rules = [],
    ): void {
        $validator = new Validator($data, $rules, UnsupportedResponseDataException::class);

        if($validator->fails()) {
            throw new UnsupportedResponseDataException();
        }
    }

    protected static function castCarbon(array $data, array $carbonCasts): array
    {
        foreach ($carbonCasts as $cast) {
            if (!empty($data[$cast])) {
                $data[$cast] = Carbon::createFromTimestamp($data[$cast]);
            }
        }

        return $data;
    }
}
