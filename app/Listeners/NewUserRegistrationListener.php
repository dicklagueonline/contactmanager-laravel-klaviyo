<?php

namespace App\Listeners;

use App\Services\KlaviyoClient;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserRegistrationListener
{
    public function __construct(KlaviyoClient $client)
    {
        $this->client = $client;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $this->client->MemberService->createMember($event->user);
        $this->client->EventTrackingService->trackRegistration($event->user);
    }
}
