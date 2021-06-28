<?php

namespace Tests\Unit;

use App\Models\Vendor;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use JWTAuth;

class VendorTest extends TestCase {

    use RefreshDatabse;
    /** @test */

    protected $user;

    //Create user and verify
    protected function authenticate() {

        $user = factory(User::class->create([
            'name' => 'John Doe',
            'email' => 'johndoe@anonymous.com',
            'password' => Hash::make('john_doe')
        ]));
        $this->user = $user;

        $token = JWTAuth::fromUser($user);

        return $token;
    }
     
    public function testCreate() {

        //Getting token
        $token = $this->authenticate();

        $response = $this->withHeaders([

            'Authorization' => 'Bearer'. $token,

        ])->json('POST', route('vendor.create'), [
            'name' => 'John Doe'
            'category' => 'Junior Role'
        ]);

        $response->assertStatus(200);

        //Get Count and assert
        $count = $this->user->assets()->count();

        $this->assertEquals(1, $count);

    }

    public function testIndex() {

        $token = $this->authenticate();

        $vendor = Vendor::create([
            'name' => 'John Doe',
            'category' => 'Junior Role'
        ]);

        $this->user->vendors()->save($vendor);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('GET', route('vendor.index'));

        $response->assertStatus(200);

        $this->assertEquals(1, count($response->json()))

        $this->assertEquals('John Doe', $response->json()[0]['name']);
      
    }

    public function testShow() {

        $token = $this->authenticate();

        $vendor = Vendor::create([
            'name' => 'John Doe',
            'category' => 'Junior Role'
        ]);

        $this->user->assets()->save($vendor);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('GET', route('vendor.show', ['vendor' => $vendor->id]));

        $response->assertStatus(200);

        $this->assertEquals('John Doe', $response->json()['name']);
      
    }

    public function testUpdate() {

        $token = $this->authenticate();

        $vendor = Vendor::create([
            'name' => 'John Doe',
            'category' => 'Junior Role'
        ]);

        $this->user->vendors()->save($vendor);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('PUT', route('vendor.update', ['vendor' => $vendor->id]));

        $response->assertStatus(200);

        $this->assertEquals('John Doe', $this->user->vendors()->first()->name);
      
    }

    public function testDelete() {

        $token = $this->authenticate();

        $vendor = Vendor::create([
            'name' => 'John Doe',
            'category' => 'Junior Role' 
        ]);

        $this->user->vendors()->save($vendor);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('DELETE', route('vendor.delete', ['vendor' => $vendor->id]));

        $response->assertStatus(200);

        //To assert there is no more assets
        $this->assertEquals(0, $this->user->vendors()->count());
     }   
}
