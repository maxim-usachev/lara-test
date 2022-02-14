<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class testUserProfileAccess extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function test()
    {
        $response1 = $this->post('/api/register', [
            'email' => 'a10@aa.w',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $userId1 = $response1->json('userId');

        $response2 = $this->post('/api/register', [
            'email' => 'a20@aa.w',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $userId2 = $response2->json('userId');

        $responseLogin = $this->post('/api/login', [
            'email' => 'a20@aa.w',
            'password' => '123456'
        ]);

        $accessToken = $responseLogin->json('access_token');

        $response = $this->patch('/api/profile/for_user/' . $userId1,
            [
                'timezone' => '+3',
                'lang' => 'us'
            ],
            ['Authorization' => 'Bearer ' . $accessToken]
        );

        $response->assertStatus(403);
    }
}
