<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\Device;

use App\Tests\Helper\ApplicationTestCase;
use App\Tests\Helper\DeviceHelper;

class ActivateDeviceControllerTest extends ApplicationTestCase
{
    public function testActivateDevice(): void
    {
        $client = static::createAuthenticatedClient('john.doe@email.com', 'S3cr3t!');

        DeviceHelper::createDevice($client, [
            'name' => 'new test device to activate',
            'address' => '10.10.50.1',
        ]);

        $devices = DeviceHelper::gelAllDevices($client);
        $deviceId = end($devices)['id'];

        DeviceHelper::activateDevice($client, $deviceId);

        $device = DeviceHelper::getDeviceById($client, $deviceId);

        $this->assertResponseIsSuccessful();
        $this->assertTrue($device['isActive']);
    }
}
