<?php

declare(strict_types=1);

namespace App\Features\Device\CreateDevice;

use Webmozart\Assert\Assert;

final readonly class CreateDeviceCommand
{
    public function __construct(
        public string $name,
        public string $address
    ) {
    }

    public static function fromArray(array $body): self
    {
        Assert::stringNotEmpty($body['name']);
        Assert::stringNotEmpty($body['address']);

        return new self(
            name: $body['name'],
            address: $body['address'],
        );
    }
}
