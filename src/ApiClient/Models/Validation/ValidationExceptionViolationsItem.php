<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Models\Validation;

class ValidationExceptionViolationsItem
{
    protected string $propertyPath;
    protected string $title;

    /** @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingTraversableTypeHintSpecification */
    protected array $parameters;
    protected string $type;

    /** @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingTraversableTypeHintSpecification */
    protected array $payload;

    public function getPropertyPath(): string
    {
        return $this->propertyPath;
    }

    public function setPropertyPath(string $propertyPath): self
    {
        $this->propertyPath = $propertyPath;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }
}
