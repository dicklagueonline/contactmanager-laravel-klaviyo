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

    public function trackButtonClicked(User $user)
    {
        $datetime = Carbon::now();

        $event = new KlaviyoEvent(
            [
                'event' => 'Clicked track me button',
                'customer_properties' => [
                    '$email' => $user->email
                ],
                'properties' => [
                    'Date and Time' => $datetime->format('Y-m-d H:i:s')
                ],
                'time' => $datetime->timestamp
            ]
        );

        return $this->client->publicAPI->track($event, true);
    }

    public function trackRegistration(User $user)
    {

        $event = new KlaviyoEvent(
            array(
                'event' => 'Filled out Profile',
                'customer_properties' => array(
                    '$email' => $user->email,
                    '$first_name' => $user->firstname,
                    '$last_name' => $user->lastname
                ),
                'properties' => array(
                    'Added Social Accounts' => False
                )
            )
        );

        $this->client->publicAPI->track($event, true);
    }
}
