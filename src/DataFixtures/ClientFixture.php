<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixture extends Fixture
{
    public const TEST_USER_FIX = 'test_user_fixed';
    public const TEST_USER_HOURLY = 'test_user_hourly';
    public const TEST_USER_JOB = 'test_user_job';

    public function __construct(private readonly UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $client = new Client();
        $client->setEmail("admin@bk.ru");
        $password = $this->hasher->hashPassword($client, 'test');
        $client->setPassword($password);
        $this->addReference(self::TEST_USER_FIX, $client);

        $client2 = new Client();
        $client2->setEmail("admin2@bk.ru");
        $password = $this->hasher->hashPassword($client2, 'test2');
        $client2->setPassword($password);
        $this->addReference(self::TEST_USER_HOURLY, $client2);

        $client3 = new Client();
        $client3->setEmail("admin3@bk.ru");
        $password = $this->hasher->hashPassword($client3, 'test3');
        $client3->setPassword($password);
        $this->addReference(self::TEST_USER_JOB, $client3);

        $manager->persist($client);
        $manager->persist($client2);
        $manager->persist($client3);
        $manager->flush();
    }
}
