<?php

namespace App\Services\Klaviyo;

use Carbon\Carbon;
use App\Models\User;
use Klaviyo\Model\EventModel as KlaviyoEvent;

class EventTrackingService
{
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function trackButtonClicked(User $user, $button)
    {
        $datetime = Carbon::now('UTC');

        $event = new KlaviyoEvent(
            [
                'event' => 'Clicked ' . strtolower($button) . ' button.',
                'customer_properties' => [
                    '$email' => $user->email
                ],
                'properties' => [
                    'datetime' => $datetime->toRfc850String()
                ],
                'time' => $datetime->timestamp
            ]
        );

        return $this->client->publicAPI->track($event, true);
    }
}
