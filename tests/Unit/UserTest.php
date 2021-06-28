<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase {

    public function testRegister() {

        //Create test user data
        $payload = [
            'name' => 'John Doe'
            'email' => 'johndoe@anonymous.com'
            'password' => 'john_doe'
        ];

        //Send a post request
        $response = $this->json('POST', route('api.register'), $payload);

        //Determine whether the transmission was successful 
        $response->assertStatus(200);

        //Receive our token
        $this->assertArrayHasKey('token', $response->json());

    public function testLogin() {

        //Creating Users
       $user = factory(User::class)->create([
           'email' => 'johndoe@anonymous.com',
           'password' => bcrypt('john_doe')
       ]);

       $payload = [ 'email' => 'johndoe@anonymous.com',
        'password' => 'john_doe'
       ];

        //Simulate Landing
        $response = $this->json('POST', route('api.login'), $payload);

        //Determine whether the login is successful and receive a token
        $response->assertStatus(200);

        //Receive token
        $this->assertArrayHasKey('token', $response->json());

     public function testLogout() {

          $user = factory(User::class)->create([
              'email' => 'johndoe@anonymous.com'
         ]);

         $token = JWTAuth::fromUser($user);

         $headers = ['Authorization' => "Bearer $token "];

         $response = $this->json('POST', route('api.logout'), [], $headers);

         //Determine whether the logout is successful and receive a token
         $response->assertStatus(200);

        }

        public function testUpdate() {


        }

        public function testDelete() {


        }

}

    







    }
    
   
}
