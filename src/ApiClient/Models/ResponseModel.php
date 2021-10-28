<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Models;

use Illuminate\Support\Collection;

interface ResponseModel
{
    public static function fromJson(string $json): static;

    public static function collectionFromJson(string $json): Collection;
}
