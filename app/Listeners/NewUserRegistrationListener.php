<?php

namespace App\Listeners;

use App\Services\KlaviyoService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserRegistrationListener
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        (new KlaviyoService())->MemberService->createMember($event->user);
        (new KlaviyoService())->EventTrackingService->trackRegistration($event->user);
    }
}
