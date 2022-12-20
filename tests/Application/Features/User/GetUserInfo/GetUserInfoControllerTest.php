<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\User\GetUserInfo;

use App\Tests\Helper\ApplicationTestCase;
use Webmozart\Assert\Assert;

class GetUserInfoControllerTest extends ApplicationTestCase
{
    public function testGetUserInfo(): void
    {
        $client = static::createAuthenticatedClient('john.doe@email.com', 'S3cr3t!');

        $client->request(
            'GET',
            '/api/user/me'
        );

        $content = $client->getResponse()->getContent();
        Assert::string($content);

        $content = json_decode($content, true);
        Assert::isArray($content);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertEquals('John', $content['firstname']);
        $this->assertEquals('Doe', $content['lastname']);
        $this->assertEquals('john.doe@email.com', $content['email']);
        $this->assertNotEmpty($content['createdAt']);
        $this->assertNotEmpty($content['updatedAt']);
    }
}
