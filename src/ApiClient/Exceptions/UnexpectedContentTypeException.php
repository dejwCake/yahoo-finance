<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Exceptions;

use RuntimeException;

final class UnexpectedContentTypeException extends RuntimeException implements ClientException
{
    public function __construct(string $contentType)
    {
        parent::__construct(sprintf('Unexpected Content Type %s', $contentType));
    }
}
