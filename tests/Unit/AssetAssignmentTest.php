<?php

namespace Tests\Unit;

use App\Models\AssetAssignment;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use JWTAuth;

class AssetAssignmentTest extends TestCase {

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

        ])->json('POST', route('assignment.create'), [
            'status' => 'Active'
            'assigned_by' => 'John Doe'
        ]);

        $response->assertStatus(200);

        //Get Count and assert
        $count = $this->user->assets_assignment()->count();

        $this->assertEquals(1, $count);

    }

    public function testIndex() {

        $token = $this->authenticate();

        $assignment = AssetAssignment::create([
            'status' => 'Active',
            'assigned_by' => 'John Doe'
        ]);

        $this->user->assets_assignment()->save($assignment);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('GET', route('assignment.index'));

        $response->assertStatus(200);

        $this->assertEquals(1, count($response->json()))

        $this->assertEquals('Active', $response->json()[0]['status']);
      
    }

    public function testShow() {

        $token = $this->authenticate();

        $assignment = AssetAssignment::create([
            'status' => 'Active',
            'assigned_by' => 'John Doe'
        ]);

        $this->user->assets_management()->save($assignment);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('GET', route('assignment.show', ['assignment' => $assignment->id]));

        $response->assertStatus(200);

        $this->assertEquals('Active', $response->json()['status']);
      
    }

    public function testUpdate() {

        $token = $this->authenticate();

        $assignment = AssetAssignment::create([
            'status' => 'Active',
            'assigned_by' => 'John Doe'
        ]);

        $this->user->assets_assignment()->save($assignment);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('PUT', route('assignment.update', ['assignment' => $assignment->id]));

        $response->assertStatus(200);

        $this->assertEquals('Active', $this->user->assets_assignment()->first()->status);
      
    }

    public function testDelete() {

        $token = $this->authenticate();

        $assignment = AssetAssignment::create([
            'status' => 'Active',
            'assigned_by' => 'John Doe' 
        ]);

        $this->user->assets_management()->save($assignment);

        //Call routing and assert response

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->json('DELETE', route('assignment.delete', ['assignment' => $assignment->id]));

        $response->assertStatus(200);

        //To assert there is no more assets
        $this->assertEquals(0, $this->user->assets_aassignment()->count());
     }   
}
