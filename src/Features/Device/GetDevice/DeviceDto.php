<?php

declare(strict_types=1);

namespace App\Features\Device\GetDevice;

final readonly class DeviceDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $address,
        public bool $isActive,
        public string $createdAt,
        public string $updatedAt,
    ) {
    }
}
