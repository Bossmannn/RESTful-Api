<?php

namespace App\Listeners;
use Mail;
use App\Events\AssetAssignmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAssetAssignmentCreated {
   
    public function __construct()
    {
        //
    }

      //Event handler function
    public function handle(AssetAssignmentCreated $event) {

        $data = ['first_name' => $event->user->first_name, 'last_name' => $event->user->last_name,
        
        'email' => $event->user->email, 'body' => 'Your asset assignment creation was successful.'];

        Mail::send('emails.mail', $data, function($message) use ($data) {

            $message->to($data['email'])
                    ->subject('Asset Assignment Creation Email')
                    ->from('noreply@anonymous.com');
        });           
    }
}
