<?php

namespace App\Listeners;
use Mail;
use App\Events\VendorCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVendorCreated
{
    
    public function __construct() {
        
        //
    }
        //Event handler function
    public function handle(VendorCreated $event) {

        $data = ['first_name' => $event->user->first_name, 'last_name' => $event->user->last_name,
        
        'email' => $event->user->email, 'body' => 'Your vendor creation was successful.'];

        Mail::send('emails.mail', $data, function($message) use ($data) {

            $message->to($data['email'])
                    ->subject('Vendor Creation Email')
                    ->from('noreply@anonymous.com');
        });       
    }
}
