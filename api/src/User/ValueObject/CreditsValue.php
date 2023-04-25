<?php

namespace App\User\ValueObject;

class CreditsValue
{
    private string $value;

    public function __construct(float $value)
    {
        $this->value = (string)round($value, 2);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
