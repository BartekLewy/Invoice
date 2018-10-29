<?php

namespace BartekLewy\Invoice\Domain\ValueObject;

/**
 * Class InvoiceId
 * @package BartekLewy\Invoice\Domain\ValueObject
 */
class InvoiceId
{
    /**
     * @var string
     */
    private $id;

    /**
     * InvoiceId constructor.
     * @param string $id
     */
    private function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $id
     * @return InvoiceId
     */
    public static function fromString(string $id): InvoiceId
    {
        return new self($id);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}