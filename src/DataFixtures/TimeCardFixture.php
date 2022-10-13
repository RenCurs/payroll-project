<?php

namespace App\DataFixtures;

use App\Entity\TimeCard;
use App\Enum\TimeTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TimeCardFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $card1 = new TimeCard();
        $card1->setEmployee($this->getReference(EmployeeFixture::EMP_HOURLY));
        $card1->setDate(new \DateTime('2022-03-03'));
        $card1->setSpentHour(4);
        $card1->setTypeTime(TimeTypeEnum::PRIMARY);
        $manager->persist($card1);

        $card2 = new TimeCard();
        $card2->setEmployee($this->getReference(EmployeeFixture::EMP_HOURLY));
        $card2->setDate(new \DateTime('2022-03-02'));
        $card2->setSpentHour(4);
        $card2->setTypeTime(TimeTypeEnum::PRIMARY);
        $manager->persist($card2);

        $card3 = new TimeCard();
        $card3->setEmployee($this->getReference(EmployeeFixture::EMP_HOURLY));
        $card3->setDate(new \DateTime('2022-03-04'));
        $card3->setSpentHour(3);
        $card3->setTypeTime(TimeTypeEnum::OVER_TIME);
        $manager->persist($card3);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [EmployeeFixture::class];
    }
}
