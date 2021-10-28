<?php

declare(strict_types=1);

namespace DejwCake\YahooFinance\Validators;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\Validator as ValidatorInterface;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

class Validator implements ValidatorInterface
{
    private ?MessageBag $messages = null;
    private array $failedRules = [];
    private array $after = [];

    public function __construct(private array $data, private array $rules, private string $exception)
    {

    }

    public function getMessageBag(): MessageBag
    {
        return $this->messages();
    }

    public function validate(): array
    {
        throw_if($this->fails(), $this->exception, $this);

        return $this->validated();
    }

    public function validated(): array
    {
        return [];
    }

    public function fails(): bool
    {
        return !$this->passes();
    }

    public function failed(): array
    {
        return $this->failedRules;
    }

    public function sometimes($attribute, $rules, callable $callback): Validator|static
    {
        return $this;
    }

    public function after($callback): Validator|static
    {
        $this->after[] = function () use ($callback) {
            return $callback($this);
        };

        return $this;
    }

    public function errors(): MessageBag
    {
        return $this->messages();
    }

    public function messages(): MessageBag
    {
        if (!$this->messages) {
            $this->passes();
        }

        return $this->messages;
    }

    public function passes(): bool
    {
        $this->messages = new MessageBag;

        $this->failedRules = [];

        foreach ($this->rules as $attribute => $rules) {
            foreach ($rules as $rule) {
                $this->validateAttribute($attribute, $rule);
            }
        }

        foreach ($this->after as $after) {
            $after();
        }

        return $this->messages->isEmpty();
    }

    private function validateAttribute(int|string $attribute, mixed $rule): void
    {
        $ruleValid = true;
        $value = $this->getValue($attribute);

        if ($rule instanceof Rule) {
            $this->validateUsingCustomRule($attribute, $value, $rule);
            return;
        }

        switch ($rule) {
            case 'required':
                $ruleValid = $value !== null;
                break;
            case 'string':
                $ruleValid = is_string($value);
                break;
            case 'numeric':
                $ruleValid = is_numeric($value);
                break;
            case 'boolean':
                $ruleValid = is_bool($value);
                break;
            case 'array':
                $ruleValid = is_array($value);
                break;
            default:
                break;
        }
        if (!$ruleValid) {
            $this->addFailure($attribute, $rule);
        }
    }

    protected function validateUsingCustomRule($attribute, $value, $rule)
    {
        if ($rule instanceof DataAwareRule) {
            $rule->setData($this->data);
        }

        if (!$rule->passes($attribute, $value)) {
            $this->failedRules[$attribute][get_class($rule)] = [];

            $messages = $rule->message();

            $messages = $messages ? (array) $messages : [get_class($rule)];

            foreach ($messages as $message) {
                $this->messages->add($attribute, $message);
            }
        }
    }

    public function addFailure($attribute, $rule, $parameters = []): void
    {
        if (!$this->messages) {
            $this->passes();
        }

        $this->messages->add($attribute, $this->getMessage($rule));

        $this->failedRules[$attribute][$rule] = $parameters;
    }

    private function getValue($attribute)
    {
        return Arr::get($this->data, $attribute);
    }

    private function getMessage($rule): string
    {
        if ($rule instanceof Rule) {
            $rule = (string) $rule;
        }
        return 'validation.' . Str::snake($rule);
    }
}
