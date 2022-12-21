<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\Device\ActivateDevice;

use App\Tests\Helper\ApplicationTestCase;
use App\Tests\Helper\DeviceHelper;
use Webmozart\Assert\Assert;

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
        Assert::string($deviceId);

        $client->request(
            'POST',
            "/api/device/$deviceId/activate"
        );

        $device = DeviceHelper::getDeviceById($client, $deviceId);

        $this->assertResponseIsSuccessful();
        $this->assertTrue($device['isActive']);
    }
}
