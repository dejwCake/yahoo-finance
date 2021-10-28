<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Exceptions;

use RuntimeException;

final class UnexpectedStatusCodeException extends RuntimeException implements ClientException
{
    public function __construct(int $status)
    {
        parent::__construct('Unexpected Status Code', $status);
    }
}
