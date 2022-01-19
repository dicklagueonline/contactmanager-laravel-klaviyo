<?php

namespace App\Services\Klaviyo;

use App\Models\User;
use Klaviyo\Model\ProfileModel as KlaviyoProfile;

class MemberService
{
    public function __construct($client)
    {
        $this->client = $client;

        $this->member_list_id = config('services.klaviyo.member_list_id');
    }

    public function createMember(User $user)
    {
        $profile = new KlaviyoProfile(
            [
                '$id' => $user->id,
                '$phone_number' => $user->phone,
                '$email' => $user->email,
                '$first_name' => $user->firstname,
                '$last_name' => $user->lastname
            ]
        );

        $this->client->publicAPI->identify($profile, true);

        $this->client->lists->addMembersToList($this->member_list_id, [$profile]);

        $person = $this->client->profiles->getProfileIdByEmail($user->email);

        $user->klaviyo()->updateOrCreate(['user_id' => $user->id], [
            'person_id' => $person['id']
        ]);

        $this->createContactList($user);

        return true;
    }

    public function deleteMember(User $user)
    {
        return $this->client->dataPrivacy->requestProfileDeletion($user->klaviyo->person_id, 'person_id');
    }

    public function updateMember(User $user)
    {
        return $this->client->profiles->updateProfile($user->klaviyo->person_id, [
            '$phone_number' => $user->phone,
            '$email' => $user->email,
            '$first_name' => $user->firstname,
            '$last_name' => $user->lastname
        ]);
    }

    public function createContactList(User $user)
    {
        $contact_list = $this->client->lists->createList($user->fullname . ' Contacts');

        $user->klaviyo()->updateOrCreate(['user_id' => $user->id], [
            'contact_list_id' => $contact_list['list_id']
        ]);

        return true;
    }

    public function updateContactList(User $user) {
        return $this->client->lists->updateListNameById($user->klaviyo->contact_list_id, $user->fullname . ' Contacts');
    }

    public function deleteContactList(User $user)
    {
        return $this->client->lists->deleteList($user->klaviyo->contact_list_id);
    }
}
