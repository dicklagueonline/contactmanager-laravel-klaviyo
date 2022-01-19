<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Services\KlaviyoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserUpdatedListener
{
    /**
     * Handle the event.
     *
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        (new KlaviyoService())->MemberService->UpdateMember($event->user);
    }
}
