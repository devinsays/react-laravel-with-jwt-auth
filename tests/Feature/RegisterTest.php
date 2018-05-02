<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

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

    /** @test */
    public function existing_user_cannot_register()
    {
        $existing_user = factory(User::class)->create();
        $user = [
            'name' => $existing_user->name,
            'email' => $existing_user->email,
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ];
        $response = $this->json('POST', '/api/auth/register', $user);
        $response->assertStatus(422);

        $message = $response->getData()->message->email[0];
        $this->assertEquals("The email has already been taken.", $message);
    }
}
