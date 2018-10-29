<?php

namespace BartekLewy\Invoice\Domain;

use BartekLewy\Invoice\Domain\ValueObject\InvoiceId;

/**
 * Interface InvoiceRepository
 * @package BartekLewy\Invoice\Domain
 */
interface InvoiceRepository
{
    /**
     * @return InvoiceId
     */
    public function nextIdentity(): InvoiceId;

    /**
     * @param Invoice $invoice
     */
    public function save(Invoice $invoice): void;
}