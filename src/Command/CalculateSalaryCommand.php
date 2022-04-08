<?php

namespace App\Command;

use App\Service\CalculateSalary;
use DateTime;
use DateTimeZone;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class CalculateSalaryCommand extends Command
{
    protected static $defaultName = 'app:calculate-salary';
    protected static $defaultDescription = 'Calculate salary for employee';

    private CalculateSalary $calculateSalary;

    public function __construct(CalculateSalary $calculateSalary)
    {
        parent::__construct();
        $this->calculateSalary = $calculateSalary;
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'pay-date',
                null,
                InputOption::VALUE_REQUIRED,
                'Option description'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dateOption = $input->getOption('pay-date');
        $date = DateTime::createFromFormat('Y-m-d', $dateOption, new DateTimeZone('Europe/Moscow'));

        if (false === $date) {
            $output->writeln('<error>Incorrect date of payment</error>');

            return Command::FAILURE;
        }

        try {
            $this->calculateSalary->execute($date);
        } catch (Throwable $exception) {
            $output->writeln(sprintf(
                '<error>%s\n%s</error>',
                $exception->getMessage(),
                $exception->getTraceAsString())
            );

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
