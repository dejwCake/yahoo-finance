<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels;

use Carbon\Carbon;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnsupportedResponseDataException;
use DejwCake\YahooFinance\ApiClient\Models\ResponseModel as ResponseModelInterface;
use DejwCake\YahooFinance\Models\CloseValue;
use DejwCake\YahooFinance\Rules\SizeRule;
use Illuminate\Support\Collection;

class StockHistory extends ResponseModel implements ResponseModelInterface
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

        if (!isset($collectionData) || !is_array($collectionData)) {
            throw new UnsupportedResponseDataException();
        }

        return (new Collection($collectionData))->map(
            static fn(array $stockHistoryData) => static::fromJson(
                json_encode($stockHistoryData, JSON_THROW_ON_ERROR),
            ),
        );
    }

    public static function fromJson(string $json): static
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        parent::validate($data, self::rules($data));

        $closeValues = new Collection();
        foreach ($data['timestamp'] as $key => $timestamp) {
            $closeValues->push(
                new CloseValue(Carbon::createFromTimestamp($timestamp), $data['close'][$key]),
            );
        }

        return new static(
            $data['symbol'],
            $data['previousClose'] ?? null,
            $data['start'] ?? null,
            $data['end'] ?? null,
            $data['chartPreviousClose'],
            $data['dataGranularity'],
            $closeValues,
        );
    }

    public static function rules(array $data): array
    {
        $closeCount = 0;
        if(isset($data['close']) && is_array($data['close'])) {
            $closeCount = count($data['close']);
        }
        $timestampCount = 0;
        if(isset($data['timestamp']) && is_array($data['timestamp'])) {
            $timestampCount = count($data['timestamp']);
        }

        return [
            'symbol' => ['required', 'string'],
            'chartPreviousClose' => ['required', 'numeric'],
            'dataGranularity' => ['required', 'numeric'],
            'timestamp' => ['required', 'array', new SizeRule($closeCount)],
            'close' => ['required', 'array', new SizeRule($timestampCount)],
        ];
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
