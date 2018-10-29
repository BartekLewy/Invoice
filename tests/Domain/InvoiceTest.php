<?php

namespace BartekLewy\Tests\Invoice\Domain;

use BartekLewy\Invoice\Domain\Exception\{InvalidNameException, ItemNotFoundException};
use BartekLewy\Invoice\Domain\Invoice;
use BartekLewy\Invoice\Domain\ValueObject\{InvoiceId, Item};
use PHPUnit\Framework\{Assert, TestCase};
use Ramsey\Uuid\Uuid;

class InvoiceTest extends TestCase
{
    public function testShouldCreateInvoice(): void
    {
        $invoiceId = InvoiceId::fromString(Uuid::uuid4()->toString());

        $invoice = new Invoice(
            $invoiceId,
            'Jan Nowak',
            'Jan Kowalski'
        );

        Assert::assertEquals($invoiceId->getId(), $invoice->getId());
        Assert::assertEquals('Jan Nowak', $invoice->getIssuer());
        Assert::assertEquals('Jan Kowalski', $invoice->getBuyer());
        Assert::assertEquals(0, $invoice->getValue());
    }

    public function testShouldProperlyAddItems(): void
    {
        $invoiceId = InvoiceId::fromString(Uuid::uuid4()->toString());

        $invoice = new Invoice(
            $invoiceId,
            'Jan Nowak',
            'Jan Kowalski'
        );

        $invoice->addItem(new Item('JetBrains PHPStorm Licence', 79.99));
        $invoice->addItem(new Item('JetBrains WebStorm  Licence', 44.99));

        Assert::assertCount(2, $invoice->getItems());
        Assert::assertEquals(124.98, $invoice->getValue());
    }

    public function testShouldProperlyAddAndRemoveItems(): void
    {
        $invoiceId = InvoiceId::fromString(Uuid::uuid4()->toString());

        $invoice = new Invoice(
            $invoiceId,
            'Jan Nowak',
            'Jan Kowalski'
        );

        $invoice->addItem(new Item('JetBrains PHPStorm Licence', 79.99));
        $invoice->addItem(new Item('JetBrains WebStorm Licence', 44.99));
        $invoice->addItem(new Item('JetBrains RubyMine Licence', 69.99));
        $invoice->addItem(new Item('JetBrains AppCode Licence', 59.99));

        $invoice->removeItem(3);

        Assert::assertCount(3, $invoice->getItems());
        Assert::assertEquals(194.97, $invoice->getValue());
    }

    public function testShouldThrowItemNotFoundException()
    {
        $this->expectException(ItemNotFoundException::class);

        $invoiceId = InvoiceId::fromString(Uuid::uuid4()->toString());

        $invoice = new Invoice(
            $invoiceId,
            'Jan Nowak',
            'Jan Kowalski'
        );

        $invoice->removeItem(0);
    }

    public function testShouldThrowInvalidNameExceptionForEmptyIssuerParameter()
    {
        $this->expectException(InvalidNameException::class);
        $invoiceId = InvoiceId::fromString(Uuid::uuid4()->toString());

        new Invoice(
            $invoiceId,
            '',
            'Jan Kowalski'
        );
    }

    public function testShouldThrowInvalidNameExceptionForEmptyBuyerParameter()
    {
        $this->expectException(InvalidNameException::class);
        $invoiceId = InvoiceId::fromString(Uuid::uuid4()->toString());

        new Invoice(
            $invoiceId,
            'Jan Nowak',
            ''
        );
    }
}