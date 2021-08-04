<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illumiate\Support\Facades\Input;
use App\Events\UserRegistered;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use JWTAuth;

//use Validator;

class UsersController extends Controller {

    public function __construct() {
        
        $this->middleware('auth:api', ['except' => ['login', 'register']]);

    }

    public function register(RegisterRequest $request) {

        $validator = $request->validated();

       if (!$validator) {

            return response()->json($validator->errors(), 422);
        } 

        $user = User::create(array_merge($validator,
                    [
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'picture_url' => $request->picture_url,
                    'phone_no' => $request->phone_no,
                    'is_disabled' => $request->is_disabled ? true : false
                    ]
        ));
         //Invoke User Registered Event...
         event(new UserRegistered($user));

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    
    }

    public function login(LoginRequest $request){

    	$validator = $request->validated();
         
        if (!$validator) {

            return response()->json($validator->errors(), 422);
        }

        $input = $request->only('email', 'password');
        $token = null;

        try {
            
        if (!$token = JWTAuth::attempt($input)) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.'
            ], 401);
          } 

       }catch(Tymon\JWTAuth\Exceptions\JWTExceptions $e){

            return response()->json([
              'success' => false,
              'message' => 'Sorry, the token could not be set.'
          ], 500);
        }
          return $this->createNewToken($token); 
     }

    public function refresh() {

      $refresh =  $this->createNewToken(auth()->refresh());

         if(!$refresh) {

            return response()->json([
            'success' => false,
            'message' => 'Sorry, the token could not be refreshed'
            ]);
         }
         return $refresh;
    }

    public function logout() {

      auth()->logout();

      return response()->json([
          'success' => true,
          'message' => 'User logged out successfully.'
      ]);
        
    } 

    protected function createNewToken($token) {

        return response()->json([
            'message' => 'Login successful',
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60000, //Get Time to Live (TTL)
            'access_token' => $token,
            'user' => auth()->user()      
        ]);
    }

    public function profile() {

        $user = auth()->user();

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user was not found.'
            ], 400);    
        }
        return $user;
    }

    public function show($id) {

        $user = auth()->user()->find($id);

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user with id ' .$id. ' was not found.'    
            ],400);
        }
        return $user;
     }

    public function update(Request $request, $id) {

        $user = auth()->user()->find($id);

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user with id ' .$id. ' was not found.'

            ], 400);
        }

        $updated = $user->fill($request->all())->save();
            
        if ($updated) {
    
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $user
            ]);
    
        } else {
    
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user could not be updated'
            ], 500);
        }
    }

    public function destroy($id) {

        $user = auth()->user()->find($id);

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user with id ' .$id. ' was not found.'
            ], 400);
        }

        $deleted = $user->delete();

        if ($deleted) {

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } else {
    
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user could not be deleted'
                  ], 500);
            }
      }
}