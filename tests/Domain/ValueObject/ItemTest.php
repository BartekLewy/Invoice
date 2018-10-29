<?php

namespace BartekLewy\Tests\Invoice\Domain\ValueObject;


use BartekLewy\Invoice\Domain\ValueObject\Item;
use PHPUnit\Framework\{Assert, TestCase};

class ItemTest extends TestCase
{
    /**
     * @dataProvider provideValidItems
     */
    public function testShouldCreateItem(string $name, float $value): void
    {
        $item = new Item($name, $value);

        Assert::assertEquals($name, $item->getName());
        Assert::assertEquals($value, $item->getValue());
    }

    public function provideValidItems(): array
    {
        return [
            ['item name', 100],
            ['item', 100.0],
            ['item with super name', 100.11]
        ];
    }

    /**
     * @dataProvider provideInvalidItems
     */
    public function testShouldThrowDomainExceptionException(string $name, float $value)
    {
        $this->expectException(\DomainException::class);
        new Item($name, $value);
    }

    public function provideInvalidItems(): array
    {
        return [
            ['name', 123.456],
            ['', 123.45],
        ];
    }
}