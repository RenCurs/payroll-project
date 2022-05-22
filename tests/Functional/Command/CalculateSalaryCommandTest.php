<?php

namespace App\Tests\Functional\Command;

use App\Command\CalculateSalaryCommand;
use App\Entity\Employee;
use App\Entity\PayCheck;
use App\Enum\PaymentTypeEnum;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CalculateSalaryCommandTest extends KernelTestCase
{
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        $this->em = static::getContainer()->get(EntityManagerInterface::class);

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

    public function testSuccessExecuteForJobPrice(): void
    {
        $app = new Application(static::$kernel);
        $command = $app->find(CalculateSalaryCommand::getDefaultName());
        $commandTester = new CommandTester($command);

        $commandTester->execute(
            [
                '--pay-date' => '2022-03-08'
            ]
        );

        /** @var PayCheck $check */
        $check = $this->em->getRepository(PayCheck::class)
            ->findOneBy(['date' => new DateTime('2022-03-08')]);

        static::assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
        static::assertNotNull($check);
        static::assertEquals(7500, $check->getSum());
        static::assertEquals(4842, $check->getTotalSum());
        static::assertEquals(2658, $check->getServicesCharge());
        static::assertEquals(0, $check->getUnionContribution());
    }

    public function testSuccessExecuteHourly(): void
    {
        $app = new Application(static::$kernel);
        $command = $app->find(CalculateSalaryCommand::getDefaultName());
        $commandTester = new CommandTester($command);

        $commandTester->execute(
            [
                '--pay-date' => '2022-03-04'
            ]
        );

        /** @var PayCheck $check */
        $check = $this->em->getRepository(PayCheck::class)
            ->findOneBy(['date' => new DateTime('2022-03-04')]);

        static::assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
        static::assertNotNull($check);
        static::assertEquals(3300, $check->getSum());
        static::assertEquals(2455, $check->getTotalSum());
        static::assertEquals(845, $check->getServicesCharge());
        static::assertEquals(0, $check->getUnionContribution());
    }

    public function testSuccessExecuteForFixedSalary(): void
    {
        $app = new Application(static::$kernel);
        $command = $app->find(CalculateSalaryCommand::getDefaultName());
        $commandTester = new CommandTester($command);

        $commandTester->execute(
            [
                '--pay-date' => '2022-03-31'
            ]
        );

        /** @var PayCheck $check */
        $check = $this->em->getRepository(PayCheck::class)
            ->findOneBy(['date' => new DateTime('2022-03-31')]);

        static::assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
        static::assertNotNull($check);
        static::assertEquals(30000, $check->getSum());
        static::assertEquals(29000, $check->getTotalSum());
        static::assertEquals(0, $check->getServicesCharge());
        static::assertEquals(1000, $check->getUnionContribution());
    }
}
