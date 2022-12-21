<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\Device\CreateDevice;

use App\Tests\Helper\ApplicationTestCase;
use App\Tests\Helper\DeviceHelper;

class CreateDeviceControllerTest extends ApplicationTestCase
{
    public function testCreateDevice(): void
    {
        $client = static::createAuthenticatedClient('john.doe@email.com', 'S3cr3t!');

        DeviceHelper::createDevice($client, [
            'name' => 'new test device',
            'address' => '10.10.10.11',
        ]);

        $this->assertResponseIsSuccessful();
    }
}
