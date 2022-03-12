<?php

namespace App\DataFixtures;

use App\Entity\SaleReceipt;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SaleReceiptFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $receipt = new SaleReceipt();
         $receipt
             ->setDate(new \DateTime('2022-03-03'))
             ->setAmount(25000)
             ->setEmployee($this->getReference(EmployeeFixture::EMP_JOBPRICE));

        $receipt2 = new SaleReceipt();
        $receipt2
            ->setDate(new \DateTime('2022-03-07'))
            ->setAmount(5000)
            ->setEmployee($this->getReference(EmployeeFixture::EMP_JOBPRICE));


         $manager->persist($receipt);
         $manager->persist($receipt2);
         $manager->flush();
    }
}
