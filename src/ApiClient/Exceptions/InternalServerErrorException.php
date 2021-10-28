<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Exceptions;

use RuntimeException;

class InternalServerErrorException extends RuntimeException implements ServerException
{
    public function __construct()
    {
        parent::__construct('Internal Server Error', 500);
    }
}
