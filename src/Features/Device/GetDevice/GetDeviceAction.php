<?php

declare(strict_types=1);

namespace App\Features\Device\GetDevice;

use App\Features\Device\FindAllDevices\DeviceDto;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final readonly class GetDeviceAction
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @throws GetDeviceException|DeviceNotFoundException|Exception
     */
    public function __invoke(string $id): DeviceDto
    {
        $stmt = $this->connection->executeQuery("SELECT * FROM device WHERE id=$id ORDER BY id");

        try {
            $result = $stmt->fetchAssociative();
        } catch (Exception $e) {
            throw new GetDeviceException();
        }

        if (false === $result) {
            throw new DeviceNotFoundException();
        }

        return new DeviceDto(
            id: (string) $result['id'],
            name: (string) $result['name'],
            address: (string) $result['address'],
            isActive: (bool) $result['is_active'],
            createdAt: null !== $result['created_at'] ? (new \DateTimeImmutable((string) $result['created_at']))->format('Y-m-d H:i:s') : '',
            updatedAt: null !== $result['updated_at'] ? (new \DateTimeImmutable((string) $result['updated_at']))->format('Y-m-d H:i:s') : '',
        );
    }
}
