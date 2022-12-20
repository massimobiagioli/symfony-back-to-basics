<?php

declare(strict_types=1);

namespace App\Tests\Integration\Features\User;

use App\Features\Device\FindAllDevices\FindAllDevicesAction;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class FindAllDevicesActionTest extends TestCase
{
    use ProphecyTrait;

    public function testInvokeAction()
    {
        $result = [
            [
                'id' => 1,
                'name' => 'test device',
                'address' => '10.10.10.1',
                'is_active' => true,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ],
        ];

        $stmt = $this->prophesize(Result::class);
        $stmt->fetchAllAssociative()->willReturn($result);

        $connection = $this->prophesize(Connection::class);
        $connection->executeQuery('SELECT * FROM device ORDER BY id')->willReturn($stmt->reveal());

        $action = new FindAllDevicesAction($connection->reveal());

        $devices = $action();

        $this->assertCount(1, $devices);
        $firstDevice = $devices[0];
        $this->assertEquals(1, $firstDevice->id);
        $this->assertEquals('test device', $firstDevice->name);
        $this->assertEquals('10.10.10.1', $firstDevice->address);
        $this->assertEquals(true, $firstDevice->isActive);
        $this->assertEquals('2021-01-01 00:00:00', $firstDevice->createdAt);
        $this->assertEquals('2021-01-01 00:00:00', $firstDevice->updatedAt);

        $stmt->fetchAllAssociative()->shouldHaveBeenCalledOnce();
        $connection->executeQuery('SELECT * FROM device ORDER BY id')->shouldHaveBeenCalledOnce();
    }
}
