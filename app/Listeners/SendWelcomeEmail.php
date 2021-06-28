<?php

namespace App\Listeners;
use Mail;
use App\Mail\NewUserNotification;
use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeEmail {
  
    public function __construct() {

        //
        
    }

    public function handle(UserRegistered $event) {

        $data = array('first_name' => $event->user->first_name, 'last_name' => $event->user->last_name,
        
        'email' => $event->user->email, 'body' => 'Welcome, Thank you for your registration.');

        Mail::send('emails.mail', $data, function($message) use ($data) {

            $message->to($data['email'])
                    ->subject('Welcome Email')
                    ->from('noreply@anonymous.com');
        });       
    }
}
