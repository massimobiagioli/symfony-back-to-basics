<?php

declare(strict_types=1);

namespace App\Tests\Unit\Features\Device;

use App\Features\Device\CreateDevice\CreateDeviceCommand;
use PHPUnit\Framework\TestCase;

class CreateDeviceCommandTest extends TestCase
{
    public function testCreateFromArray()
    {
        $data = [
            'name' => 'test device',
            'address' => '10.10.10.1',
        ];
        $command = CreateDeviceCommand::fromArray($data);

        $this->assertEquals('test device', $command->name);
        $this->assertEquals('10.10.10.1', $command->address);
    }
}
