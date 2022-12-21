<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\Device;

use App\Tests\Helper\ApplicationTestCase;
use App\Tests\Helper\DeviceHelper;

class GetDeviceControllerTest extends ApplicationTestCase
{
    public function testFindAllDevices(): void
    {
        $client = static::createAuthenticatedClient('john.doe@email.com', 'S3cr3t!');

        $devices = DeviceHelper::gelAllDevices($client);

        $deviceId = $devices[0]['id'];
        $deviceName = $devices[0]['name'];

        $firstDevice = DeviceHelper::getDeviceById($client, $deviceId);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertEquals($deviceId, $firstDevice['id']);
        $this->assertEquals($deviceName, $firstDevice['name']);
    }

    public function testFindAllDevicesWithInvalidId(): void
    {
        $client = static::createAuthenticatedClient('john.doe@email.com', 'S3cr3t!');

        $client->request(
            'GET',
            '/api/device/999999'
        );

        $this->assertResponseStatusCodeSame(404);
    }
}
