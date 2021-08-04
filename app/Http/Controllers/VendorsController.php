<?php

namespace App\Http\Controllers;

use App\Events\VendorCreated;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Http\Requests\VendorRequest;
use JWTAuth;

class VendorsController extends Controller {

    protected $user;

    public function __construct() {

        $this->user = JWTAuth::parseToken()->authenticate();

    }

   public function index() {

      return $this->user->vendors()
                        ->get(['user_id','name', 'category'])
                        ->toArray();
           }

   public function store(VendorRequest $request) {

      $validator = $request->validated();

      if (!$validator) {
          
          return response()->json($validator->errors(), 422);
      }

      $vendor = new Vendor();
      $vendor->name = $request->name;
      $vendor->category = $request->category;

      //Invoke Vendor Creation Event...
      event(new VendorCreated($vendor));
      
   if ($this->user->vendors()->save($vendor))
      return response()->json([
          'success' => true,
          'message' => 'Vendor added successfully',
          'vendor' => $vendor
      ]);
   else 
       return response()->json([
           'success' => false,
           'message' => 'Sorry, vendor could not be added.'
       ]);
    
   }

   public function show($id) {

     $vendor = $this->user->vendors()->find($id);

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the vendor with id ' .$id. ' was not found.'
            ], 400);
        }
        return $vendor;
   }

   public function update(Request $request, $id) {

    $vendor = $this->user->vendors()->find($id);

    if (!$vendor) {

        return response()->json([
            'success' => false,
            'message' => 'Sorry, the vendor with id ' .$id. ' was not found.'
        ], 400);
    }

    $updated = $vendor->fill($request->all())->save();
            
    if ($updated) {

        return response()->json([
            'success' => true,
            'message' => 'Vendor updated successfully.',
            'vendor' => $vendor
        ]);

    } else {

        return response()->json([
            'success' => false,
            'message' => 'Sorry, vendor could not be updated',
        ], 500);
    }

 }

   public function destroy($id) {

    $vendor = $this->user->vendors()->find($id);

    if (!$vendor) {

        return response()->json([
            'success' => false,
            'message' => 'Sorry, the vendor with id ' .$id. ' was not found.'
        ], 400);
    }

    $deleted = $vendor->delete();

    if ($deleted) {

        return response()->json([
            'success' => true,
            'message' => 'Vendor deleted successfully.',
        ]);
    } else {

        return response()->json([
            'success' => false,
            'message' => 'Sorry, the vendor could not be deleted'
              ], 500);
         }
    }  
}
