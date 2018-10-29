<?php

namespace BartekLewy\Invoice\Domain;

use BartekLewy\Invoice\Domain\ValueObject\InvoiceId;
use BartekLewy\Invoice\Domain\ValueObject\Item;
use BartekLewy\Invoice\Domain\Exception\ItemNotFoundException;
use BartekLewy\Invoice\Domain\Exception\InvalidNameException;

final class Invoice
{
    /** @var InvoiceId */
    private $invoiceId;

    /** @var string */
    private $issuer;

    /** @var string */
    private $buyer;

    /** @var float */
    private $value;

    /** @var Item */
    private $items = [];

    public function __construct(InvoiceId $invoiceId, string $issuer, string $buyer)
    {
        $this->invoiceId = $invoiceId;
        if (empty($issuer)) {
            throw new InvalidNameException('Issuer name is invalid, it cannot be empty.');
        }
        $this->issuer = $issuer;

        if (empty($buyer)) {
            throw new InvalidNameException('Buyer name is invalid, it cannot be empty.');
        }
        $this->buyer = $buyer;
    }

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    public function removeItem(int $key): void
    {
        if (!array_key_exists($key, $this->items)) {
            throw new ItemNotFoundException();
        }
        unset($this->items[$key]);
    }

    public function getId(): string
    {
        return $this->invoiceId->getId();
    }

    public function getIssuer(): string
    {
        return $this->issuer;
    }

    public function getBuyer(): string
    {
        return $this->buyer;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getValue(): float
    {
        $value = 0;

        foreach($this->items as $item) {
            $value += $item->getValue();
        }

        return $value;
    }
}