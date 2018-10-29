<?php

namespace BartekLewy\Invoice\Application\DTO;

/**
 * Class NewInvoiceDTO
 * @package BartekLewy\Invoice\Application\DTO
 */
class NewInvoiceDTO
{
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
    private $items;

    /**
     * NewInvoiceDTO constructor.
     * @param string $issuer
     * @param string $buyer
     * @param array $items
     */
    public function __construct(string $issuer, string $buyer, array $items = [])
    {
        $this->issuer = $issuer;
        $this->buyer = $buyer;
        $this->items = $items;
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
}