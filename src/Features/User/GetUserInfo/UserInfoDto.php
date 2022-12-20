<?php

declare(strict_types=1);

namespace App\Features\User\GetUserInfo;

final readonly class UserInfoDto
{
    public function __construct(
        public string $email,
        public string $firstname,
        public string $lastname,
        public string $createdAt,
        public string $updatedAt,
    ) {
    }
}
