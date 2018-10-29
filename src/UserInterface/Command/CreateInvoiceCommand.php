<?php

namespace BartekLewy\Invoice\UserInterface\Command;

use BartekLewy\Invoice\Application\DTO\NewInvoiceDTO;
use BartekLewy\Invoice\Application\InvoiceService;
use BartekLewy\Invoice\Infrastructure\InMemoryInvoiceRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class CreateInvoiceCommand
 * @package BartekLewy\Invoice\UserInterface\Command
 */
class CreateInvoiceCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:create-invoice')
            ->setDescription('Creates new invoice')
            ->setHelp('This command allows you to provide new invoice to system');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $issuerQuestion = new Question('<question>Please, type a name of issuer: </question>');
        $issuerQuestion->setValidator($this->notNullValidator());
        $issuer = $helper->ask($input, $output, $issuerQuestion);

        $buyerQuestion = new Question('<question>Please, type a name of buyer: </question>');
        $buyerQuestion->setValidator($this->notNullValidator());
        $buyer = $helper->ask($input, $output, $buyerQuestion);

        $confirmationQuestion = new ConfirmationQuestion('<question>Would you like add new item now? [Y/n] </question>', true);

        $items = [];

        while ($helper->ask($input, $output, $confirmationQuestion)) {
            $itemNameQuestion = new Question('<question>Please, type a product name: </question>');
            $itemNameQuestion->setValidator($this->notNullValidator());
            $itemName = $helper->ask($input, $output, $itemNameQuestion);

            $itemValueQuestion = new Question('<question>Please, type a product value: </question>');
            $itemValueQuestion->setValidator($this->notNullValidator());
            $itemValue = $helper->ask($input, $output, $itemValueQuestion);

            $items[] = [
                'name' => $itemName,
                'value' => $itemValue
            ];
        }

        $invoiceService = new InvoiceService(new InMemoryInvoiceRepository());
        $createdInvoiceId = $invoiceService->create(
            new NewInvoiceDTO($issuer, $buyer, $items)
        );

        $output->writeln('<info>Good job! New invoice has been applied to system. Here is Invoice ID: </info>' . $createdInvoiceId);

    }

    private function notNullValidator()
    {
        return function ($value) {
            if (trim($value) == '') {
                throw new \Exception('This value cannot be empty');
            }

            return $value;
        };
    }
}