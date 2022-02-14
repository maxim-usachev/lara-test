<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class testRegistration extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @test
     *
     * @return void
     */
    public function test_registration()
    {
        $response = $this->post('/api/register', [
            'email' => 'a10@aa.w',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'a10@aa.w',
        ]);

        $response->assertStatus(201);
    }
}
