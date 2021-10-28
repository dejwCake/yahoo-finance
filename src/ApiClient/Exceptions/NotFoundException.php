<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Exceptions;

use RuntimeException;

class NotFoundException extends RuntimeException implements ClientException
{
    public function __construct()
    {
        parent::__construct('Not Found', 404);
    }
}
