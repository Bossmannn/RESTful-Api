<?php

namespace Tests\Unit;

use App\Models\Asset;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use JWTAuth;

class AssetTest extends TestCase {

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

        ])->json('POST', route('asset.create'), [
            'type' => 'House'
            'description' => 'Duplex'
        ]);

        $response->assertStatus(200);

        //Get Count and assert
        $count = $this->user->assets()->count();

        $this->assertEquals(1, $count);

    }

    public function testIndex() {

        $token = $this->authenticate();

        $asset = Asset::create([
            'type' => 'House',
            'description' => 'Duplex'
        ]);

        $this->user->assets()->save($asset);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('GET', route('asset.index'));

        $response->assertStatus(200);

        $this->assertEquals(1, count($response->json()))

        $this->assertEquals('House', $response->json()[0]['type']);
      
    }

    public function testShow() {

        $token = $this->authenticate();

        $asset = Asset::create([
            'type' => 'House',
            'description' => 'Duplex'
        ]);

        $this->user->assets()->save($asset);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('GET', route('asset.show', ['asset' => $asset->id]));

        $response->assertStatus(200);

        $this->assertEquals('House', $response->json()['type']);
      
    }

    public function testUpdate() {

        $token = $this->authenticate();

        $asset = Asset::create([
            'type' => 'House',
            'description' => 'Duplex'
        ]);

        $this->user->assets()->save($asset);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('PUT', route('asset.update', ['asset' => $asset->id]));

        $response->assertStatus(200);

        $this->assertEquals('House', $this->user->assets()->first()->type);
      
    }

    public function testDelete() {

        $token = $this->authenticate();

        $asset = Asset::create([
            'type' => 'House',
            'description' => 'Duplex'
        ]);

        $this->user->assets()->save($asset);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('DELETE', route('asset.delete', ['asset' => $asset->id]));

        $response->assertStatus(200);

        //To assert there is no more assets
        $this->assertEquals(0, $this->user->assets()->count());
     }

}
