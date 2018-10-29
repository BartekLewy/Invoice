<?php

namespace BartekLewy\Invoice\Domain;

use BartekLewy\Invoice\Domain\ValueObject\{Item, InvoiceId};
use BartekLewy\Invoice\Domain\Exception\{ItemNotFoundException, InvalidNameException};

/**
 * Class Invoice
 * @package BartekLewy\Invoice\Domain
 */
final class Invoice
{
    /**
     * @var InvoiceId
     */
    private $invoiceId;

    /**
     * @var string
     */
    private $issuer;

    /**
     * @var string
     */
    private $buyer;

    /**
     * @var array
     */
    private $items = [];

    /**
     * Invoice constructor.
     * @param InvoiceId $invoiceId
     * @param string $issuer
     * @param string $buyer
     */
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

    /**
     * @param Item $item
     */
    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param int $key
     */
    public function removeItem(int $key): void
    {
        if (!array_key_exists($key, $this->items)) {
            throw new ItemNotFoundException();
        }
        unset($this->items[$key]);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->invoiceId->getId();
    }

    /**
     * @return string
     */
    public function getIssuer(): string
    {
        return $this->issuer;
    }

    /**
     * @return string
     */
    public function getBuyer(): string
    {
        return $this->buyer;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        $value = 0;

        foreach ($this->items as $item) {
            $value += $item->getValue();
        }

        return $value;
    }
}