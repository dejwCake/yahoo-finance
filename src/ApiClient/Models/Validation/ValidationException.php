<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\ApiClient\Models\Validation;

class ValidationException
{
    protected string $type;
    protected string $title;
    protected string $status;
    protected string $detail;
    protected string $instance;

    /** @var ValidationExceptionViolationsItem[] */
    protected array $violations;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDetail(): string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function getInstance(): string
    {
        return $this->instance;
    }

    public function setInstance(string $instance): self
    {
        $this->instance = $instance;

        return $this;
    }

    /**
     * @return ValidationExceptionViolationsItem[]
     */
    public function getViolations(): array
    {
        return $this->violations;
    }

    /**
     * @param ValidationExceptionViolationsItem[] $violations
     */
    public function setViolations(array $violations): self
    {
        $this->violations = $violations;

        return $this;
    }
}
