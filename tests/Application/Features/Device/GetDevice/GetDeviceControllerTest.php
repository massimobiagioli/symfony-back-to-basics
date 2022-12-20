<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\Device\GetDevice;

use App\Tests\Helper\ApplicationTestCase;
use Webmozart\Assert\Assert;

class GetDeviceControllerTest extends ApplicationTestCase
{
    public function testFindAllDevices(): void
    {
        $client = static::createAuthenticatedClient('john.doe@email.com', 'S3cr3t!');

        $client->request(
            'GET',
            '/api/device'
        );

        $content = $client->getResponse()->getContent();
        Assert::string($content);

        $content = json_decode($content, true);
        Assert::isArray($content);

        $deviceId = $content[0]['id'];
        $deviceName = $content[0]['name'];

        $client->request(
            'GET',
            "/api/device/$deviceId"
        );

        $content = $client->getResponse()->getContent();
        Assert::string($content);

        $content = json_decode($content, true);
        Assert::isArray($content);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertEquals($deviceId, $content['id']);
        $this->assertEquals($deviceName, $content['name']);
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
