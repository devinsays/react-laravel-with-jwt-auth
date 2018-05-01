<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function new_user_can_register()
    {
        $new_user = [
            'name' => 'Name',
            'email' => 'name@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ];

        $response = $this->json('POST', '/api/auth/register', $new_user);
        $response->assertStatus(200);
    }
}
