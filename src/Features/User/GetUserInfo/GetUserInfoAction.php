<?php

declare(strict_types=1);

namespace App\Features\User\GetUserInfo;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class GetUserInfoAction
{
    public function __construct(
    ) {
    }

    public function __invoke(UserInterface $user): UserInfoDto
    {
        if (!$user instanceof User) {
            throw new UserNotFoundException();
        }

        return new UserInfoDto(
            $user->email,
            $user->firstname,
            $user->lastname,
            null !== $user->createdAt ? $user->createdAt->format('Y-m-d H:i:s') : '',
            null !== $user->updatedAt ? $user->updatedAt->format('Y-m-d H:i:s') : '',
        );
    }
}
