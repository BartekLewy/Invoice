<?php

namespace BartekLewy\Invoice\Application;

use BartekLewy\Invoice\Application\DTO\NewInvoiceDTO;
use BartekLewy\Invoice\Domain\{Invoice, InvoiceRepository};
use BartekLewy\Invoice\Domain\ValueObject\Item;

/**
 * Class InvoiceService
 * @package BartekLewy\Invoice\Application
 */
class InvoiceService
{
    /**
     * @var InvoiceRepository
     */
    private $repository;

    /**
     * InvoiceService constructor.
     * @param InvoiceRepository $repository
     */
    public function __construct(InvoiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(NewInvoiceDTO $invoiceDTO): string
    {
        $identity = $this->repository->nextIdentity();
        $invoice = new Invoice(
            $identity,
            $invoiceDTO->getIssuer(),
            $invoiceDTO->getBuyer()
        );

        foreach ($invoiceDTO->getItems() as $item) {
            $invoice->addItem(new Item($item['name'], $item['value']));
        }

        return $identity->getId();
    }

}