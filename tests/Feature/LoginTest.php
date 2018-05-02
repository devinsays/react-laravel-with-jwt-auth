<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function registered_user_can_login()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('password')
        ]);

        $credentials = [
            'email' => $user['email'],
            'password' => 'password'
        ];

        $response = $this->json('POST', '/api/auth/login', $credentials);
        $response->assertStatus(200);
        $this->assertNotNull($response->getData()->token);
    }

    /** @test */
    public function unregistered_user_cannot_login()
    {
        $credentials = [
            'email' => 'unregistered@example.com',
            'password' => 'password'
        ];

        $response = $this->json('POST', '/api/auth/login', $credentials);
        $response->assertStatus(401);

        $error = $response->getData()->error;
        $this->assertEquals("invalid_credentials", $error);
    }

}
