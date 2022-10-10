<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Enum\PaymentScheduleEnum;
use App\Enum\PaymentTypeEnum;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixture extends Fixture
{
    final public const TEST_USER = 'test_user';
    final public const EMP_HOURLY = 'emp_hourly';
    final public const EMP_JOBPRICE = 'emp_jobprice';

    public function load(ObjectManager $manager): void
    {
         $user = new Employee();
         $user
             ->setFio('Иванов Иван Иванович')
             ->setAddress('г. Ростов-на-Дону, ул. Ленина, д.45')
             ->setDateBirth(new DateTime('2000-01-01'))
             ->setPaymentSchedule(PaymentScheduleEnum::MONTHLY)
             ->setSalary(30000)
             ->setSalaryType(PaymentTypeEnum::FIXED)
             ->setIsUnionAffiliation(true)
             ->setLastPayDate(new DateTime());

         $this->addReference(self::TEST_USER, $user);

        $anotherUser = new Employee();
        $anotherUser
            ->setFio('Иванов Иван Петрович')
            ->setAddress('г. Ростов-на-Дону, ул. Ленина, д.45')
            ->setDateBirth(new DateTime('2000-01-01'))
            ->setPaymentSchedule(PaymentScheduleEnum::WEEKLY)
            ->setHourTariff(300)
            ->setSalaryType(PaymentTypeEnum::HOURLY)
            ->setIsUnionAffiliation(false)
            ->setLastPayDate(new DateTime());

        $this->addReference(self::EMP_HOURLY, $anotherUser);

        $manager->persist($user);
        $manager->persist($anotherUser);

        $userJobprice = new Employee();
        $userJobprice
            ->setFio('Михаилов Евгений Петрович')
            ->setAddress('г. Ростов-на-Дону, ул. Вятка, д.45')
            ->setDateBirth(new DateTime('2000-01-01'))
            ->setPaymentSchedule(PaymentScheduleEnum::BIWEEKLY)
            ->setCommissionRate(25)
            ->setSalaryType(PaymentTypeEnum::JOBPRICE)
            ->setIsUnionAffiliation(false)
            ->setLastPayDate(new DateTime('2022-02-22'));

        $this->addReference(self::EMP_JOBPRICE, $userJobprice);

        $manager->persist($user);
        $manager->persist($anotherUser);
        $manager->persist($userJobprice);

        $manager->flush();
    }
}
