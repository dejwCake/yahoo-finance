<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Models\Factories;

use DejwCake\YahooFinance\ApiClient\Models\ResponseModel;
use Illuminate\Support\Collection;

interface ResponseModelFactory
{
    public function create(string $json): ResponseModel;

    public function collection(string $json): Collection;
}
