<?php

declare(strict_types=1);

namespace App\Tests\Unit\Features\Auth\RegisterUser;

use App\Features\Auth\RegisterUser\RegisterUserCommand;
use PHPUnit\Framework\TestCase;

class RegisterUserCommandTest extends TestCase
{
    public function testCreateFromArray()
    {
        $data = [
            'password' => 'Secr3T123!',
            'firstname' => 'Pippo',
            'lastname' => 'Baudo',
            'email' => 'pippo.baudo@gmail.com',
        ];
        $command = RegisterUserCommand::fromArray($data);

        $this->assertEquals('Secr3T123!', $command->password);
        $this->assertEquals('Pippo', $command->firstname);
        $this->assertEquals('Baudo', $command->lastname);
        $this->assertEquals('pippo.baudo@gmail.com', $command->email);
    }
}
