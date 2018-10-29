<?php

namespace BartekLewy\Invoice\Domain\ValueObject;

final class InvoiceId
{
    /** @var string */
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromString(string $id): InvoiceId
    {
        return new self($id);
    }

    public function getId(): string
    {
        return $this->id;
    }
}