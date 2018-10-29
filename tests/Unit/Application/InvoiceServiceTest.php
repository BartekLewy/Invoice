<?php

namespace BartekLewy\Tests\Invoice\Unit\Application;

use BartekLewy\Invoice\Application\DTO\NewInvoiceDTO;
use BartekLewy\Invoice\Application\InvoiceService;
use BartekLewy\Invoice\Domain\InvoiceRepository;
use BartekLewy\Invoice\Domain\ValueObject\InvoiceId;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class InvoiceServiceTest extends TestCase
{
    /**
     * @var InvoiceService
     */
    private $systemUnderTest;

    /**
     * @var InvoiceRepository|MockObject
     */
    private $invoiceRepositoryMock;

    public function setUp()
    {
        $this->invoiceRepositoryMock = $this->createMock(InvoiceRepository::class);
        $this->systemUnderTest = new InvoiceService($this->invoiceRepositoryMock);
    }

    public function testShouldAddNewInvoiceToStorage()
    {
        $uuid = Uuid::uuid4()->toString();
        $this->invoiceRepositoryMock->method('nextIdentity')->willReturn(InvoiceId::fromString($uuid));

        $newInvoiceDTO = new NewInvoiceDTO('Jan Kowalski', 'Jan Nowak', [
            ['name' => 'WebStorm', 'value' => 44.99],
            ['name' => 'PHPStorm', 'value' => 79.99],
            ['name' => 'RubyMine', 'value' => 69.99],
        ]);

        Assert::assertEquals($uuid, $this->systemUnderTest->create($newInvoiceDTO));
    }
}