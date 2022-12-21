<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\Device;

use App\Tests\Helper\ApplicationTestCase;
use App\Tests\Helper\DeviceHelper;

class UpdateDeviceControllerTest extends ApplicationTestCase
{
    public function testUpdateDevice(): void
    {
        $client = static::createAuthenticatedClient('john.doe@email.com', 'S3cr3t!');

        DeviceHelper::createDevice($client, [
            'name' => 'new test device to activate',
            'address' => '10.10.50.1',
        ]);

        $devices = DeviceHelper::gelAllDevices($client);
        $deviceId = end($devices)['id'];

        DeviceHelper::updateDevice($client, $deviceId, ['name' => 'new test device updated']);
        $deviceAfterUpdate = DeviceHelper::getDeviceById($client, $deviceId);

        $this->assertResponseIsSuccessful();
        $this->assertEquals('new test device updated', $deviceAfterUpdate['name']);
    }
}
