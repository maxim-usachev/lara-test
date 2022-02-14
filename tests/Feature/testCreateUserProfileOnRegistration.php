<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class testCreateUserProfileOnRegistration extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function test_userProfileCreate()
    {
        $response = $this->post('/api/register', [
            'email' => 'a10@aa.w',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $this->assertDatabaseHas('user_profile', [
            'user_id' => $response->json('userId')
        ]);
    }
}
