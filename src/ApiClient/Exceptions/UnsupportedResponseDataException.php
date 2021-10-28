<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Exceptions;

use RuntimeException;

final class UnsupportedResponseDataException extends RuntimeException implements ClientException
{
    public function __construct()
    {
        parent::__construct('Unsupported Response Data');
    }
}
