<?php

declare(strict_types=1);

namespace App\Features\Device\ActivateDevice;

use App\Entity\Device;
use App\Shared\Device\DeviceNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

final readonly class ActivateDeviceAction
{
    public function __construct(
        private ManagerRegistry $doctrine,
    ) {
    }

    /**
     * @throws DeviceNotFoundException
     */
    public function __invoke(string $id): void
    {
        $em = $this->doctrine->getManager();

        $device = $em->find(Device::class, $id);
        if (!$device) {
            throw new DeviceNotFoundException();
        }

        $device->activate();

        $em->persist($device);
        $em->flush();
    }
}
