<?php

namespace App\Services\Klaviyo;

use App\Models\User;
use App\Models\Contact;
use Klaviyo\Model\ProfileModel as KlaviyoProfile;

class ContactService
{
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function createContact(User $user, Contact $contact)
    {
        if( !$user->klaviyo ) {
            return;
        }

        $profile = new KlaviyoProfile([
            '$id' => $contact->id,
            '$user_id' => $user->id,
            '$phone_number' => $contact->phone,
            '$email' => $contact->email,
            '$first_name' => $contact->firstname
        ]);

        $this->client->publicAPI->identify($profile, true);

        $this->client->lists->addMembersToList($user->klaviyo->contact_list_id, [$profile]);

        $person = $this->client->profiles->getProfileIdByEmail($contact->email);

        $contact->klaviyo()->updateOrCreate(['contact_id' => $contact->id], [
            'person_id' => $person['id']
        ]);
    }

    public function deleteContact(Contact $contact)
    {
        if( !$contact->klaviyo ) {
            return;
        }

        return $this->client->dataPrivacy->requestProfileDeletion($contact->klaviyo->person_id, 'person_id');
    }

    public function updateContact(Contact $contact)
    {
        if( !$contact->klaviyo ) {
            return;
        }

        return $this->client->profiles->updateProfile($contact->klaviyo->person_id, [
            '$phone_number' => $contact->phone,
            '$email' => $contact->email,
            '$first_name' => $contact->firstname
        ]);
    }
}
