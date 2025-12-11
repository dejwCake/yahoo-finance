<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\RequestModels;

use DejwCake\YahooFinance\ApiClient\Models\RequestModel;
use DejwCake\YahooFinance\Models\Enums\Lang;
use DejwCake\YahooFinance\Models\Enums\Region;

final readonly class GetStockQuoteRequest implements RequestModel
{
    public function __construct(
        public array $symbols,
        public ?Region $region = Region::US,
        public ?Lang $lang = Lang::EN,
    ) {
    }

    public function getSymbolsAsString(): string
    {
        return implode(',', $this->symbols);
    }

    public function jsonSerialize(): array
    {
        return [
            'symbols' => $this->symbols,
            'region' => $this->region->value,
            'lang' => $this->lang->value,
        ];
    }
}
