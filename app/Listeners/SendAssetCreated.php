<?php

namespace App\Listeners;
use Mail;
use App\Events\AssetCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAssetCreated {
   
    public function __construct() {

        //
    }
    
      //Event handler function
    public function handle(AssetCreated $event) {

        $data = ['first_name' => $event->user->first_name, 'last_name' => $event->user->last_name,
        
        'email' => $event->user->email, 'body' => 'Your asset creation was successful.'];

        Mail::send('emails.mail', $data, function($message) use ($data) {

            $message->to($data['email'])
                    ->subject('Asset Creation Email')
                    ->from('noreply@anonymous.com');
        });       
    }
}
