<?php

namespace App\DataFixtures;

use App\Entity\TimeCard;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TimeCardFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $card = new TimeCard();
        $card->setEmployee($this->getReference(EmployeeFixture::EMP_HOURLY));
        $card->setDate(new \DateTime());
        $card->setSpentHour(8);

        $manager->persist($card);
        $manager->flush();
    }
}
