<?php

declare(strict_types=1);

namespace App\Tests\Integration\Features\User;

use App\Entity\User;
use App\Features\User\GetUserInfo\GetUserInfoAction;
use App\Features\User\GetUserInfo\UserInfoDto;
use App\Features\User\GetUserInfo\UserNotFoundException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Security\Core\User\UserInterface;

class GetUserInfoActionTest extends TestCase
{
    use ProphecyTrait;

    public function testInvokeAction()
    {
        $user = new User(
            email: 'user@email.com',
            firstname: 'John',
            lastname: 'Doe',
        );

        $action = new GetUserInfoAction();

        $userInfo = $action($user);

        $this->assertInstanceOf(UserInfoDto::class, $userInfo);
        $this->assertEquals('user@email.com', $userInfo->email);
        $this->assertEquals('John', $userInfo->firstname);
        $this->assertEquals('Doe', $userInfo->lastname);
        $this->assertEmpty($userInfo->createdAt);
        $this->assertEmpty($userInfo->updatedAt);
    }

    public function testInvokeActionWithUserNotFoundException()
    {
        $this->expectException(UserNotFoundException::class);

        $user = new class() implements UserInterface {
            public function getRoles(): array
            {
                return [];
            }

            public function eraseCredentials()
            {
            }

            public function getUserIdentifier(): string
            {
                return '';
            }
        };

        $action = new GetUserInfoAction();

        $action($user);
    }
}
