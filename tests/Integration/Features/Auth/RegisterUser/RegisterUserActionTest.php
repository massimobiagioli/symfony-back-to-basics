<?php

declare(strict_types=1);

namespace App\Tests\Integration\Features\Auth\RegisterUser;

use App\Entity\User;
use App\Features\Auth\RegisterUser\RegisterUserAction;
use App\Features\Auth\RegisterUser\RegisterUserCommand;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserActionTest extends TestCase
{
    use ProphecyTrait;

    public function testInvokeAction()
    {
        $data = [
            'password' => 'buzzword',
            'firstname' => 'Pippo',
            'lastname' => 'Baudo',
            'email' => 'pippo.baudo@gmail.com',
        ];
        $command = RegisterUserCommand::fromArray($data);
        $user = new User(
            firstname: $command->firstname,
            lastname: $command->lastname,
            email: $command->email,
        );
        $hashedPassword = 'hashedPassword';

        $passwordHasher = $this->prophesize(UserPasswordHasherInterface::class);
        $passwordHasher->hashPassword($user, $data['password'])->willReturn($hashedPassword);
        $em = $this->prophesize(ObjectManager::class);
        $doctrine = $this->prophesize(ManagerRegistry::class);
        $doctrine->getManager()->willReturn($em->reveal());

        $action = new RegisterUserAction(
            $doctrine->reveal(),
            $passwordHasher->reveal()
        );

        $action($command);

        $passwordHasher->hashPassword($user, $data['password'])->shouldHaveBeenCalledOnce();
        $em->persist($user->withHashedPassword($hashedPassword))->shouldHaveBeenCalledOnce();
        $em->flush()->shouldHaveBeenCalledOnce();
    }
}
