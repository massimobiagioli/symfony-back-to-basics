<?php

declare(strict_types=1);

namespace App\Features\Auth\RegisterUser;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class RegisterUserAction
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $em = $this->doctrine->getManager();

        $user = new User(
            firstname: $command->firstname,
            lastname: $command->lastname,
            email: $command->email,
        );

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $command->password
        );

        $em->persist($user->withHashedPassword($hashedPassword));
        $em->flush();
    }
}
