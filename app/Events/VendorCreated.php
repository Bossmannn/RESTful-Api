<?php

namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use JWTAuth;

class VendorCreated {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct() {

        $this->user =  JWTAuth::parseToken()->authenticate();;
    
    }

  
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
