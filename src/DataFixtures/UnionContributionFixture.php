<?php

namespace App\DataFixtures;

use App\Entity\UnionContribution;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UnionContributionFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $contribution = new UnionContribution();
        $contribution
            ->setEmployee($this->getReference(EmployeeFixture::EMP_FIXED))
            ->setSum(1000)
            ->setDateStart(new DateTime('2022-03-21'))
            ->setDateEnd(new DateTime('2022-03-25'));

        $manager->persist($contribution);
        $manager->flush();
    }

    // TODO Абстрактная фикстура для этого
    public function getDependencies(): array
    {
        return [EmployeeFixture::class];
    }
}
