<?php

namespace App\DataFixtures;

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
}
