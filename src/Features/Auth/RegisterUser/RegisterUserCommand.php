<?php

declare(strict_types=1);

namespace App\Features\Auth\RegisterUser;

use Webmozart\Assert\Assert;

final readonly class RegisterUserCommand
{
    public function __construct(
        public string $password,
        public string $firstname,
        public string $lastname,
        public string $email
    ) {
    }

    public static function fromArray(array $body): self
    {
        Assert::stringNotEmpty($body['password']);
        Assert::stringNotEmpty($body['firstname']);
        Assert::stringNotEmpty($body['lastname']);
        Assert::stringNotEmpty($body['email']);

        return new self(
            password: $body['password'],
            firstname: $body['firstname'],
            lastname: $body['lastname'],
            email: $body['email']
        );
    }
}
