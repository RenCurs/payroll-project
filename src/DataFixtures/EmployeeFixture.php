<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Enum\PaymentScheduleEnum;
use App\Enum\PaymentTypeEnum;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixture extends Fixture implements DependentFixtureInterface
{
    final public const EMP_FIXED = 'emp_fixed';
    final public const EMP_HOURLY = 'emp_hourly';
    final public const EMP_JOBPRICE = 'emp_jobprice';

    public function load(ObjectManager $manager): void
    {
        $employee = new Employee();
        $employee
            ->setFio('Иванов Иван Иванович')
            ->setAddress('г. Ростов-на-Дону, ул. Ленина, д.45')
            ->setDateBirth(new DateTime('2000-01-01'))
            ->setPaymentSchedule(PaymentScheduleEnum::MONTHLY)
            ->setSalary(30000)
            ->setSalaryType(PaymentTypeEnum::FIXED)
            ->setIsUnionAffiliation(true)
            ->setLastPayDate(new DateTime())
            ->setClient($this->getReference(ClientFixture::TEST_USER_FIX));

        $this->addReference(self::EMP_FIXED, $employee);

        $employee2 = new Employee();
        $employee2
            ->setFio('Иванов Иван Петрович')
            ->setAddress('г. Ростов-на-Дону, ул. Ленина, д.45')
            ->setDateBirth(new DateTime('2000-01-01'))
            ->setPaymentSchedule(PaymentScheduleEnum::WEEKLY)
            ->setHourTariff(300)
            ->setSalaryType(PaymentTypeEnum::HOURLY)
            ->setIsUnionAffiliation(false)
            ->setLastPayDate(new DateTime())
            ->setClient($this->getReference(ClientFixture::TEST_USER_HOURLY));

        $this->addReference(self::EMP_HOURLY, $employee2);

        $employee3 = new Employee();
        $employee3
            ->setFio('Михаилов Евгений Петрович')
            ->setAddress('г. Ростов-на-Дону, ул. Вятка, д.45')
            ->setDateBirth(new DateTime('2000-01-01'))
            ->setPaymentSchedule(PaymentScheduleEnum::BIWEEKLY)
            ->setCommissionRate(25)
            ->setSalaryType(PaymentTypeEnum::JOBPRICE)
            ->setIsUnionAffiliation(false)
            ->setLastPayDate(new DateTime('2022-02-22'))
            ->setClient($this->getReference(ClientFixture::TEST_USER_JOB));

        $this->addReference(self::EMP_JOBPRICE, $employee3);

        $manager->persist($employee);
        $manager->persist($employee2);
        $manager->persist($employee3);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ClientFixture::class
        ];
    }
}
