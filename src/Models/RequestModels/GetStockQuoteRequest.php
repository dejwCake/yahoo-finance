<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\RequestModels;

use DejwCake\YahooFinance\ApiClient\Models\RequestModel;
use DejwCake\YahooFinance\Models\Enums\Lang;
use DejwCake\YahooFinance\Models\Enums\Region;

class GetStockQuoteRequest implements RequestModel
{
    private ?Region $region;
    private ?Lang $lang;

    public function __construct(private array $symbols, ?Region $region = null, ?Lang $lang = null)
    {
        $this->region = $region ?? Region::US();
        $this->lang = $lang ?? Lang::EN();
    }

    public function getSymbols(): array
    {
        return $this->symbols;
    }

    public function setSymbols(array $symbols): self
    {
        $this->symbols = $symbols;

        return $this;
    }

    public function getSymbolsAsString(): string
    {
        return implode(',', $this->getSymbols());
    }

    public function getRegion(): Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getLang(): Lang
    {
        return $this->lang;
    }

    public function setLang(Lang $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'symbols' => $this->getSymbols(),
            'region' => $this->getRegion()->getValue(),
            'lang' => $this->getLang()->getValue(),
        ];
    }
}
