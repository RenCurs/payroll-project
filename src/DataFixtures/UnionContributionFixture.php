<?php

namespace App\DataFixtures;

use App\Entity\UnionContribution;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UnionContributionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contribution = new UnionContribution();
        $contribution
            ->setEmployee($this->getReference(EmployeeFixture::TEST_USER))
            ->setSum(1000);

        $manager->persist($contribution);
        $manager->flush();
    }
}
