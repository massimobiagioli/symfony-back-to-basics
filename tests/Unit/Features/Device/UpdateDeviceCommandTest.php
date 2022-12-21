<?php

declare(strict_types=1);

namespace App\Tests\Unit\Features\Device;

use App\Features\Device\UpdateDevice\UpdateDeviceCommand;
use PHPUnit\Framework\TestCase;

class UpdateDeviceCommandTest extends TestCase
{
    public function testCreateFromArray()
    {
        $data = [
            'name' => 'test device',
            'address' => '10.10.10.1',
        ];
        $command = UpdateDeviceCommand::fromArray($data);

        $this->assertEquals('test device', $command->name);
        $this->assertEquals('10.10.10.1', $command->address);
    }

    public function testCreateFromArrayPartial()
    {
        $data = [
            'name' => 'test device',
        ];
        $command = UpdateDeviceCommand::fromArray($data);

        $this->assertEquals('test device', $command->name);
        $this->assertNull($command->address);
    }
}
