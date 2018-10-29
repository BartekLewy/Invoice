<?php

namespace BartekLewy\Invoice\Domain\ValueObject;

use BartekLewy\Invoice\Domain\Exception\{InvalidItemValueException, InvalidNameException};

final class Item
{
    private const MAX_DECIMALS_NUMBER = 2;

    /** @var string */
    private $name;

    /** @var float */
    private $value;

    public function __construct(string $name, float $value)
    {
        if (empty($name)) {
            throw new InvalidNameException();
        }

        $this->name = $name;
        if (mb_strlen(mb_substr(strrchr($value, "."), 1)) > self::MAX_DECIMALS_NUMBER) {
            throw new InvalidItemValueException();
        }
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}