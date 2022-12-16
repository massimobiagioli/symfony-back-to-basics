<?php

declare(strict_types=1);

namespace App\Tests\Application\Features\Auth\RegisterUser;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserControllerTest extends WebTestCase
{
    public function testRegisterUser(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/auth/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'password' => 'buzzword',
                'firstname' => 'Pippo',
                'lastname' => 'Baudo',
                'email' => 'pippo.baudo@gmail.com',
            ])
        );

        $this->assertResponseIsSuccessful();
    }
}
