<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Exceptions;

use DejwCake\YahooFinance\ApiClient\Models\Validation\ValidationException;
use RuntimeException;

class UnprocessableEntityException extends RuntimeException implements ClientException
{
    public function __construct(private ValidationException $validationException)
    {
        parent::__construct('Validation Failed', 422);
    }

    public function getValidationException(): ValidationException
    {
        return $this->validationException;
    }
}
