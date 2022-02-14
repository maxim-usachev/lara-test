<?php

namespace Tests\Feature;

use App\Events\userRegisteredEvent;
use App\Listeners\sendWelcomeEmail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class testSendWelcomeEmail extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Event::fake();

        $response = $this->post('/api/register', [
            'email' => 'a10@aa.w',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        Event::assertListening(userRegisteredEvent::class, sendWelcomeEmail::class);
    }
}
