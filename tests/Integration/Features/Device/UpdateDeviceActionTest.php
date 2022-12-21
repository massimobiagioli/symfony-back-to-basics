<?php

declare(strict_types=1);

namespace App\Tests\Integration\Features\Device;

use App\Entity\Device;
use App\Features\Device\UpdateDevice\UpdateDeviceAction;
use App\Features\Device\UpdateDevice\UpdateDeviceCommand;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class UpdateDeviceActionTest extends TestCase
{
    use ProphecyTrait;

    public function testInvokeAction()
    {
        $data = [
            'name' => 'test device updated',
        ];
        $command = UpdateDeviceCommand::fromArray($data);

        $device = new Device(
            name: 'test device',
            address: '10.10.10.1',
        );

        $id = '123';

        $em = $this->prophesize(ObjectManager::class);
        $em->find(Device::class, $id)->willReturn($device);

        $doctrine = $this->prophesize(ManagerRegistry::class);
        $doctrine->getManager()->willReturn($em->reveal());

        $action = new UpdateDeviceAction(
            $doctrine->reveal()
        );

        $action($id, $command);

        $em->persist($device)->shouldHaveBeenCalledOnce();
        $em->flush()->shouldHaveBeenCalledOnce();
    }
}
