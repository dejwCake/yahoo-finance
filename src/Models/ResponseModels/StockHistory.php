<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels;

use Carbon\Carbon;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnsupportedResponseDataException;
use DejwCake\YahooFinance\ApiClient\Models\ResponseModel;
use DejwCake\YahooFinance\Models\CloseValue;
use Illuminate\Support\Collection;

class StockHistory implements ResponseModel
{
    public function __construct(
        private string $symbol,
        private ?float $previousClose,
        private ?Carbon $start,
        private ?Carbon $end,
        private float $chartPreviousClose,
        private int $dataGranularity,
        private Collection $closeValues,
    ) {
    }

    public static function collectionFromJson(string $json): Collection
    {
        $collectionData = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        return (new Collection($collectionData))->map(
            static fn (array $stockHistoryData) => static::fromJson(
                json_encode($stockHistoryData, JSON_THROW_ON_ERROR),
            ),
        );
    }

    public static function fromJson(string $json): static
    {
        $stockHistoryData = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        static::validate($stockHistoryData);

        $closeValues = new Collection();
        foreach ($stockHistoryData['timestamp'] as $key => $timestamp) {
            $closeValues->push(
                new CloseValue(Carbon::createFromTimestamp($timestamp), $stockHistoryData['close'][$key]),
            );
        }

        return new static(
            $stockHistoryData['symbol'],
            $stockHistoryData['previousClose'] ?? null,
            $stockHistoryData['start'] ?? null,
            $stockHistoryData['end'] ?? null,
            $stockHistoryData['chartPreviousClose'],
            $stockHistoryData['dataGranularity'],
            $closeValues,
        );
    }

    private static function validate(array $stockHistoryData): bool
    {
        if (
            !isset(
                $stockHistoryData['symbol'],
                $stockHistoryData['chartPreviousClose'],
                $stockHistoryData['dataGranularity'],
                $stockHistoryData['timestamp'],
                $stockHistoryData['close'],
            )
            || !is_array($stockHistoryData['timestamp'])
            || !is_array($stockHistoryData['close'])
            || count($stockHistoryData['timestamp']) !== count($stockHistoryData['close'])
        ) {
            throw new UnsupportedResponseDataException();
        }

        return true;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPreviousClose(): ?float
    {
        return $this->previousClose;
    }

    public function getStart(): ?Carbon
    {
        return $this->start;
    }

    public function getEnd(): ?Carbon
    {
        return $this->end;
    }

    public function getChartPreviousClose(): ?float
    {
        return $this->chartPreviousClose;
    }

    public function getDataGranularity(): ?int
    {
        return $this->dataGranularity;
    }

    public function getCloseValues(): Collection
    {
        return $this->closeValues;
    }
}
