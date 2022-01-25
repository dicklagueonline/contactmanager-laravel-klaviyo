<?php

namespace App\Services;

use Klaviyo\Klaviyo;

class KlaviyoClient
{
    protected $client;

    public function __construct()
    {
        $this->client =  new Klaviyo(config('services.klaviyo.secret'), config('services.klaviyo.key'));
    }

    public function __get($service)
    {
        $service = __NAMESPACE__ . '\\Klaviyo\\' . ucfirst($service);

        if (class_exists($service)) {
            return new $service($this->client);
        }

        return null;
    }
}
