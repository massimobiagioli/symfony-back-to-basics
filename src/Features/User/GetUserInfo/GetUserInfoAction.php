<?php

declare(strict_types=1);

namespace App\Features\User\GetUserInfo;

use App\Entity\User;
use App\Features\User\Shared\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class GetUserInfoAction
{
    public function __construct(
    ) {
    }

    public function __invoke(UserInterface $user): GetUserInfoDto
    {
        if (!$user instanceof User) {
            throw new UserNotFoundException();
        }

        return new GetUserInfoDto(
            $user->email,
            $user->firstname,
            $user->lastname,
            null !== $user->createdAt ? $user->createdAt->format('Y-m-d H:i:s') : '',
            null !== $user->updatedAt ? $user->updatedAt->format('Y-m-d H:i:s') : '',
        );
    }
}
