<?php

namespace BartekLewy\Invoice\Infrastructure;

use BartekLewy\Invoice\Domain\{Invoice, InvoiceRepository, ValueObject\InvoiceId};
use Ramsey\Uuid\Uuid;

/**
 * Class InMemoryInvoiceRepository
 * @package BartekLewy\Invoice\Infrastructure
 */
class InMemoryInvoiceRepository implements InvoiceRepository
{
    /**
     * @var array
     */
    private $container = [];

    /**
     * @param Invoice $invoice
     */
    public function save(Invoice $invoice): void
    {
        $this->container[$invoice->getId()] = $invoice;
    }

    /**
     * @return InvoiceId
     * @throws \Exception
     */
    public function nextIdentity(): InvoiceId
    {
        return InvoiceId::fromString(Uuid::uuid4()->toString());
    }
}