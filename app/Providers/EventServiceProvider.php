<?php

namespace App\Providers;

use App\Events\ContactChunkImportProcessed;
use App\Events\ContactCreated;
use App\Events\ContactDeleted;
use App\Events\ContactImportFileDataLoaded;
use App\Events\ContactsImported;
use App\Events\ContactUpdated;
use App\Events\UserUpdated;
use App\Listeners\ContactChunkImportListener;
use App\Listeners\ContactCreatedListener;
use App\Listeners\ContactDeletedListener;
use App\Listeners\ContactImportNotification;
use App\Listeners\ContactUpdatedListener;
use App\Listeners\NewUserRegistrationListener;
use App\Listeners\ProcessImportContactListener;
use App\Listeners\UserUpdatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            NewUserRegistrationListener::class
        ],
        ContactImportFileDataLoaded::class => [
            ProcessImportContactListener::class
        ],
        ContactCreated::class => [
            ContactCreatedListener::class
        ],
        ContactUpdated::class => [
            ContactUpdatedListener::class
        ],
        ContactDeleted::class => [
            ContactDeletedListener::class
        ],
        ContactChunkImportProcessed::class => [
            ContactChunkImportListener::class
        ],
        UserUpdated::class => [
            UserUpdatedListener::class
        ],
        ContactsImported::class => [
            ContactImportNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
