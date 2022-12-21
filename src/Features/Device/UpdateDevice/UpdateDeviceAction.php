<?php

declare(strict_types=1);

namespace App\Features\Device\UpdateDevice;

use App\Entity\Device;
use App\Shared\Device\DeviceNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

final readonly class UpdateDeviceAction
{
    public function __construct(
        private ManagerRegistry $doctrine,
    ) {
    }

    /**
     * @throws DeviceNotFoundException
     */
    public function __invoke(string $id, UpdateDeviceCommand $command): void
    {
        $em = $this->doctrine->getManager();

        $device = $em->find(Device::class, $id);
        if (null === $device) {
            throw new DeviceNotFoundException();
        }

        if (null !== $command->name) {
            $device->name = $command->name;
        }

        if (null !== $command->address) {
            $device->address = $command->address;
        }

        $em->persist($device);
        $em->flush();
    }
}
