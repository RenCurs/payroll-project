<?php

namespace App\Tests\Functional\Command;

use App\Command\CalculateSalaryCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CalculateSalaryCommandTest extends KernelTestCase
{
    protected function setUp(): void
    {
        static::bootKernel();
    }

    public function testFailedExecute(): void
    {
        $app = new Application(static::$kernel);
        $command = $app->find(CalculateSalaryCommand::getDefaultName());
        $commandTester = new CommandTester($command);

        $commandTester->execute(
            [
                '--pay-date' => 'Invalid date'
            ]
        );

        static::assertEquals(Command::FAILURE, $commandTester->getStatusCode());
        static::assertEquals("Incorrect date of payment\n", $commandTester->getDisplay());
    }

    public function testSuccessExecute(): void
    {
        $app = new Application(static::$kernel);
        $command = $app->find(CalculateSalaryCommand::getDefaultName());
        $commandTester = new CommandTester($command);

        $commandTester->execute(
            [
                '--pay-date' => '2022-03-04'
            ]
        );
    }
}
