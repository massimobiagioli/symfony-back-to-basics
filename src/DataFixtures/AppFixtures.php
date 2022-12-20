<?php

namespace App\DataFixtures;

use App\Entity\Device;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(
        UserPasswordHasherInterface $hasher
    ) {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadDevices($manager);
        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager): void
    {
        $user = new User(
            firstname: 'John',
            lastname: 'Doe',
            email: 'john.doe@email.com'
        );
        $hashedPassword = $this->hasher->hashPassword(
            $user,
            'S3cr3t!'
        );

        $manager->persist($user->withHashedPassword($hashedPassword));
    }

    private function loadDevices(ObjectManager $manager): void
    {
        $device = new Device(
            name: 'First device',
            address: '10.10.10.1'
        );
        $manager->persist($device);

        $device = new Device(
            name: 'Second device',
            address: '10.10.10.2'
        );
        $manager->persist($device);
    }
}
