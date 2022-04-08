<?php

namespace App\DataFixtures;

use App\Entity\UnionContribution;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UnionContributionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contribution = new UnionContribution();
        $contribution
            ->setEmployee($this->getReference(EmployeeFixture::TEST_USER))
            ->setSum(1000)
            ->setDateStart(new DateTime('2022-02-14'))
            ->setDateEnd(new DateTime('2022-02-18'));

        $manager->persist($contribution);
        $manager->flush();
    }
}
