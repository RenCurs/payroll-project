<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CalculateSalaryCommand extends Command
{
    protected static $defaultName = 'app:calculate-salary';
    protected static $defaultDescription = 'Calculate salary for employee';

    protected function configure(): void
    {
        $this
            ->addOption(
                'Date of payment',
                null,
                InputOption::VALUE_REQUIRED,
                'Option description'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }
}
