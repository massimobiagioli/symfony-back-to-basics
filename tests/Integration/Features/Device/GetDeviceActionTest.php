<?php

declare(strict_types=1);

namespace App\Tests\Integration\Features\Device;

use App\Features\Device\GetDevice\GetDeviceAction;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class GetDeviceActionTest extends TestCase
{
    use ProphecyTrait;

    public function testInvokeAction()
    {
        $result = [
            'id' => 1,
            'name' => 'test device',
            'address' => '10.10.10.1',
            'is_active' => true,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ];

        $stmt = $this->prophesize(Result::class);
        $stmt->fetchAssociative()->willReturn($result);

        $connection = $this->prophesize(Connection::class);
        $connection->executeQuery(Argument::any())->willReturn($stmt->reveal());

        $action = new GetDeviceAction($connection->reveal());

        $device = $action('1');

        $this->assertEquals(1, $device->id);
        $this->assertEquals('test device', $device->name);
        $this->assertEquals('10.10.10.1', $device->address);
        $this->assertEquals(true, $device->isActive);
        $this->assertEquals('2021-01-01 00:00:00', $device->createdAt);
        $this->assertEquals('2021-01-01 00:00:00', $device->updatedAt);

        $stmt->fetchAssociative()->shouldHaveBeenCalledOnce();
        $connection->executeQuery(Argument::any())->shouldHaveBeenCalledOnce();
    }
}
