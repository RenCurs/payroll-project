<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Enum\PaymentScheduleEnum;
use App\Enum\PaymentTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixture extends Fixture
{
    public const TEST_USER = 'test_user';
    public const EMP_HOURLY = 'emp_hourly';

    public function load(ObjectManager $manager): void
    {
         $user = new Employee();
         $user
             ->setFio('Иванов Иван Иванович')
             ->setAddress('г. Ростов-на-Дону, ул. Ленина, д.45')
             ->setDateBirth(new \DateTime('2000-01-01'))
             ->setPaymentSchedule(PaymentScheduleEnum::MONTHLY)
             ->setSalary(30000)
             ->setSalaryType(PaymentTypeEnum::FIXED)
             ->setIsUnionAffiliation(true);

         $this->addReference(self::TEST_USER, $user);

        $anotherUser = new Employee();
        $anotherUser
            ->setFio('Иванов Иван Петрович')
            ->setAddress('г. Ростов-на-Дону, ул. Ленина, д.45')
            ->setDateBirth(new \DateTime('2000-01-01'))
            ->setPaymentSchedule(PaymentScheduleEnum::WEEKLY)
            ->setHourTariff(300)
            ->setSalaryType(PaymentTypeEnum::HOURLY)
            ->setIsUnionAffiliation(false);

        $this->addReference(self::EMP_HOURLY, $anotherUser);

        $manager->persist($user);
        $manager->persist($anotherUser);

        $manager->flush();
    }
}
