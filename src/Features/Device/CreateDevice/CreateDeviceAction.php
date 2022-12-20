<?php

declare(strict_types=1);

namespace App\Features\Device\CreateDevice;

use App\Entity\Device;
use Doctrine\Persistence\ManagerRegistry;

final readonly class CreateDeviceAction
{
    public function __construct(
        private ManagerRegistry $doctrine,
    ) {
    }

    public function __invoke(CreateDeviceCommand $command): void
    {
        $em = $this->doctrine->getManager();

        $device = new Device(
            name: $command->name,
            address: $command->address,
        );

        $em->persist($device);
        $em->flush();
    }
}
