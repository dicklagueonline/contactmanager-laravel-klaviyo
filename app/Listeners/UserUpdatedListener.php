<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Services\KlaviyoClient;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUpdatedListener
{
    public function __construct(KlaviyoClient $client)
    {
        $this->client = $client;
    }

    /**
     * Handle the event.
     *
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        $this->client->MemberService->UpdateMember($event->user);
    }
}
