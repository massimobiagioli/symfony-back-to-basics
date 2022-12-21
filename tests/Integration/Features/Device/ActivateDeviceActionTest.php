<?php

declare(strict_types=1);

namespace App\Tests\Integration\Features\Device;

use App\Entity\Device;
use App\Features\Device\ActivateDevice\ActivateDeviceAction;
use App\Features\Device\CreateDevice\CreateDeviceCommand;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class ActivateDeviceActionTest extends TestCase
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

        $id = '123';

        $em = $this->prophesize(ObjectManager::class);
        $em->find(Device::class, $id)->willReturn($device);
        $doctrine = $this->prophesize(ManagerRegistry::class);
        $doctrine->getManager()->willReturn($em->reveal());

        $action = new ActivateDeviceAction(
            $doctrine->reveal()
        );

        $action($id);

        $em->persist($device)->shouldHaveBeenCalledOnce();
        $em->flush()->shouldHaveBeenCalledOnce();
    }
}
