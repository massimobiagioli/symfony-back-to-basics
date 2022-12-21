<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\Device;

use App\Tests\Helper\ApplicationTestCase;
use App\Tests\Helper\DeviceHelper;

class FindAllDevicesControllerTest extends ApplicationTestCase
{
    public function testFindAllDevices(): void
    {
        $client = static::createAuthenticatedClient('john.doe@email.com', 'S3cr3t!');

        $devices = DeviceHelper::gelAllDevices($client);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertNotEmpty($devices[0]['id']);
        $this->assertEquals('First device', $devices[0]['name']);
        $this->assertEquals('10.10.10.1', $devices[0]['address']);
        $this->assertNotEmpty($devices[1]['id']);
        $this->assertEquals('Second device', $devices[1]['name']);
        $this->assertEquals('10.10.10.2', $devices[1]['address']);
    }
}
