<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Webmozart\Assert\Assert;

class ApplicationTestCase extends WebTestCase
{
    /**
     * Create a client with a default Authorization header.
     */
    protected function createAuthenticatedClient(string $username = 'user', string $password = 'password'): KernelBrowser
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/auth/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => $username,
                'password' => $password,
            ])
        );

        $content = $client->getResponse()->getContent();
        Assert::string($content);

        $content = json_decode($content, true);
        Assert::isArray($content);

        $client->setServerParameter(
            'HTTP_Authorization',
            sprintf(
                'Bearer %s',
                $content['token']
            )
        );

        return $client;
    }
}
