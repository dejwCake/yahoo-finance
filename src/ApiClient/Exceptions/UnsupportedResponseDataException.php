<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Exceptions;

use RuntimeException;
use Throwable;

final class UnsupportedResponseDataException extends RuntimeException implements ClientException
{
    public function __construct(string $message = 'Unsupported Response Data', ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
