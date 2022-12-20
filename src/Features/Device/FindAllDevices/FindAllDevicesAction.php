<?php

declare(strict_types=1);

namespace App\Features\Device\FindAllDevices;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final readonly class FindAllDevicesAction
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @return DeviceDto[]
     *
     * @throws FindAllDevicesException|Exception
     */
    public function __invoke(): array
    {
        $stmt = $this->connection->executeQuery('SELECT * FROM device ORDER BY id');

        try {
            $result = $stmt->fetchAllAssociative();

            return array_map(fn (array $row) => new DeviceDto(
                id: (string) $row['id'],
                name: (string) $row['name'],
                address: (string) $row['address'],
                isActive: (bool) $row['is_active'],
                createdAt: null !== $row['created_at'] ? (new \DateTimeImmutable((string) $row['created_at']))->format('Y-m-d H:i:s') : '',
                updatedAt: null !== $row['updated_at'] ? (new \DateTimeImmutable((string) $row['updated_at']))->format('Y-m-d H:i:s') : '',
            ), $result);
        } catch (Exception $e) {
            throw new FindAllDevicesException();
        }
    }
}
