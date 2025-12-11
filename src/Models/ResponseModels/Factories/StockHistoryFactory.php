<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Models\ResponseModels\Factories;

use Carbon\CarbonImmutable;
use DejwCake\YahooFinance\ApiClient\Exceptions\UnsupportedResponseDataException;
use DejwCake\YahooFinance\ApiClient\Models\Factories\ResponseModelFactory as ResponseModelFactoryInterface;
use DejwCake\YahooFinance\Models\CloseValue;
use DejwCake\YahooFinance\Models\ResponseModels\StockHistory;
use Illuminate\Support\Collection;
use JsonException;
use Psr\Log\LoggerInterface;
use Throwable;
use TypeError;

final readonly class StockHistoryFactory extends ResponseModelFactory implements ResponseModelFactoryInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function collection(string $json): Collection
    {
        try {
            $collectionData = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new UnsupportedResponseDataException('Json response not correct.', $jsonException);
        }

        if (!isset($collectionData) || !is_array($collectionData)) {
            throw new UnsupportedResponseDataException();
        }

        return (new Collection($collectionData))->map(
            function (array $stockHistoryData) {
                try {
                    return $this->create(json_encode($stockHistoryData, JSON_THROW_ON_ERROR));
                } catch (Throwable $throwable) {
                    $this->logger->error($throwable->getMessage());

                    return null;
                }
            },
        )->filter();
    }

    public function create(string $json): StockHistory
    {
        try {
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new UnsupportedResponseDataException('Json response not correct.', $jsonException);
        }

        $this->validateRequired($data, $this->requiredFields());

        if (
            !is_array($data['timestamp'])
            || !is_array($data['close'])
            || count($data['timestamp']) !== count($data['close'])
        ) {
            throw new UnsupportedResponseDataException('Timestamp and close arrays has not same length.');
        }

        $closeValues = new Collection();
        foreach ($data['timestamp'] as $key => $timestamp) {
            $closeValues->push(
                new CloseValue(CarbonImmutable::createFromTimestamp($timestamp), $data['close'][$key]),
            );
        }

        try {
            return new StockHistory(
                $data['symbol'],
                $data['previousClose'] ?? null,
                $data['start'] ?? null,
                $data['end'] ?? null,
                $data['chartPreviousClose'] ?? null,
                $data['dataGranularity'] ?? null,
                $closeValues,
            );
        } catch (TypeError $typeError) {
            throw new UnsupportedResponseDataException('Type error occurred.', $typeError);
        }
    }

    private function requiredFields(): array
    {
        return [
            'symbol',
            'timestamp',
            'close',
        ];
    }
}
