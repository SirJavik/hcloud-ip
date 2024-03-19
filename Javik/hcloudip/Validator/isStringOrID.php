<?php

namespace Javik\hcloudip\Validator;

class isStringOrID
{
    protected mixed $value;

    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    public function __invoke(): bool
    {
        return is_string($this->getValue()) or is_int($this->getValue());
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}