<?php

namespace App\DataFixtures;

use App\Entity\ServicesCharge;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServicesChargeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $charge1 = new ServicesCharge();
        $charge1
            ->setEmployee($this->getReference(EmployeeFixture::EMP_JOBPRICE))
            ->setName('Test service')
            ->setDate(new DateTime('2022-03-04'))
            ->setCost(2200);

        $charge2 = new ServicesCharge();
        $charge2
            ->setEmployee($this->getReference(EmployeeFixture::EMP_JOBPRICE))
            ->setName('Test service')
            ->setDate(new DateTime('2022-03-03'))
            ->setCost(458);

        $charge3 = new ServicesCharge();
        $charge3
            ->setEmployee($this->getReference(EmployeeFixture::EMP_HOURLY))
            ->setName('Test service')
            ->setDate(new DateTime('2022-03-03'))
            ->setCost(845);

        $manager->persist($charge1);
        $manager->persist($charge2);
        $manager->persist($charge3);

        $manager->flush();
    }
}
