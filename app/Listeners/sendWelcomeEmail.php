<?php

namespace App\Listeners;

use App\Events\userRegisteredEvent;
use App\Services\Infrastructure\EmailSenderService;

class sendWelcomeEmail
{
    private EmailSenderService $emailSenderService;

    /**
     * Create the event listener.
     *
     * @param EmailSenderService $emailSenderService
     */
    public function __construct(EmailSenderService $emailSenderService)
    {
        $this->emailSenderService = $emailSenderService;
    }

    /**
     * Handle the event.
     *
     * @param userRegisteredEvent $event
     * @return void
     */
    public function handle(userRegisteredEvent $event)
    {
        $this->emailSenderService->__invoke($event->getUser()->id);
    }
}
