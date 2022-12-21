<?php

declare(strict_types=1);

namespace App\Features\Device\UpdateDevice;

final readonly class UpdateDeviceCommand
{
    public function __construct(
        public ?string $name,
        public ?string $address
    ) {
    }

    public static function fromArray(array $body): self
    {
        return new self(
            name: isset($body['name']) ? (string) $body['name'] : null,
            address: isset($body['address']) ? (string) $body['address'] : null,
        );
    }
}
