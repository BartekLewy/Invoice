<?php

namespace BartekLewy\Invoice\Domain\ValueObject;

use BartekLewy\Invoice\Domain\Exception\{InvalidItemValueException, InvalidNameException};

/**
 * Class Item
 * @package BartekLewy\Invoice\Domain\ValueObject
 */
final class Item
{
    private const MAX_DECIMALS_NUMBER = 2;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $value;

    /**
     * Item constructor.
     * @param string $name
     * @param float $value
     */
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}