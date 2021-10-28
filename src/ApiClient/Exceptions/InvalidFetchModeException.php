<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Exceptions;

use RuntimeException;

class InvalidFetchModeException extends RuntimeException implements ClientException
{
}
