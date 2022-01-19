<?php

namespace App\Services;

use Klaviyo\Klaviyo;

class KlaviyoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Klaviyo(config('services.klaviyo.secret'), config('services.klaviyo.key'));
    }

    // (new KlaviyoService())->MemberService->createMember($user);
    // (new KlaviyoService())->MemberService->updateMember($user);
    // (new KlaviyoService())->MemberService->deleteMember($user);
    // (new KlaviyoService())->MemberService->createContactList($user);
    // (new KlaviyoService())->MemberService->deleteContactList($user);

    // (new KlaviyoService())->ContactService->addContact($user, $contact);
    // (new KlaviyoService())->ContactService->deleteContact($contact);
    // (new KlaviyoService())->ContactService->updateContact($contact);

    public function __get($service)
    {
        $service = __NAMESPACE__ . '\\Klaviyo\\' . ucfirst($service);

        if (class_exists($service)) {
            return new $service($this->client);
        }

        return null;
    }
}
