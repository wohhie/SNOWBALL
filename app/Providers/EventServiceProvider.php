<?php

namespace App\Providers;

use App\Events\BuoyCreated;
use App\Events\BuoyDeleted;
use App\Events\BuoyUpdated;
use App\Listeners\BuoyCacheListener;
use App\Observers\QumatikObserver;
use App\Models\Qumatik;
use Illuminate\Support\Facades\Event;
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

        ],

        BuoyCreated::class => [
           BuoyCacheListener::class,
        ],

        BuoyUpdated::class => [
            BuoyCacheListener::class,
        ],

        BuoyDeleted::class => [
            BuoyCacheListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Qumatik::observe(QumatikObserver::class);
    }
}
