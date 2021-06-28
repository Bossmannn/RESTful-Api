<?php

namespace App\Providers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\UserRegistered;
use App\Events\AssetCreated;
use App\Events\VendorCreated;
use App\Events\AssetAssigmentCreated;
use App\Listeners\SendVendorCreated;
use App\Listeners\SendAssetCreated;
use App\Listeners\SendAssetAssignmentCreated;
use App\Listeners\SendWelcomeEmail;
use App\Mail\NewUserNotification;

class EventServiceProvider extends ServiceProvider {
  
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],  
        'App\Events\UserRegistered' => [
            'App\Listeners\SendWelcomeEmail',
        ],
        'App\Events\VendorCreated' => [
            'App\Listeners\SendVendorCreated',
        ],
        'App\Events\AssetCreated' => [
            'App\Listeners\SendAssetCreated',
        ],
        'App\Events\AssetAssignmentCreated' => [
            'App\Listeners\SendAssetAssignmentCreated',
        ],

    ];

   
    public function boot()
    {
        
    }
}
