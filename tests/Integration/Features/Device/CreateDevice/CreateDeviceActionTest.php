<?php

declare(strict_types=1);

namespace App\Tests\Integration\Features\Device\CreateDevice;

use App\Entity\Device;
use App\Features\Device\CreateDevice\CreateDeviceAction;
use App\Features\Device\CreateDevice\CreateDeviceCommand;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class CreateDeviceActionTest extends TestCase
{
    use ProphecyTrait;

    public function testInvokeAction()
    {
        $data = [
            'name' => 'test device',
            'address' => '10.10.10.1',
        ];
        $command = CreateDeviceCommand::fromArray($data);

        $device = new Device(
            name: $command->name,
            address: $command->address,
        );

        $em = $this->prophesize(ObjectManager::class);
        $doctrine = $this->prophesize(ManagerRegistry::class);
        $doctrine->getManager()->willReturn($em->reveal());

        $action = new CreateDeviceAction(
            $doctrine->reveal()
        );

        $action($command);

        $em->persist($device)->shouldHaveBeenCalledOnce();
        $em->flush()->shouldHaveBeenCalledOnce();
    }
}
