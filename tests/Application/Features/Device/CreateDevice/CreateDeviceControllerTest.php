<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\Device\CreateDevice;

use App\Tests\Helper\ApplicationTestCase;

class CreateDeviceControllerTest extends ApplicationTestCase
{
    public function testCreateDevice(): void
    {
        $client = static::createAuthenticatedClient('john.doe@email.com', 'S3cr3t!');

        $client->request(
            'POST',
            '/api/device',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'test device',
                'address' => '10.10.10.1',
            ])
        );

        $this->assertResponseIsSuccessful();
    }
}