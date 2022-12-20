<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\Device\FindAllDevicesControllerTest;

use App\Tests\Helper\ApplicationTestCase;
use Webmozart\Assert\Assert;

class FindAllDevicesControllerTest extends ApplicationTestCase
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

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertNotEmpty($content[0]['id']);
        $this->assertEquals('First device', $content[0]['name']);
        $this->assertEquals('10.10.10.1', $content[0]['address']);
        $this->assertFalse($content[0]['isActive']);
        $this->assertNotEmpty($content[1]['id']);
        $this->assertEquals('Second device', $content[1]['name']);
        $this->assertEquals('10.10.10.2', $content[1]['address']);
        $this->assertFalse($content[1]['isActive']);
    }
}
