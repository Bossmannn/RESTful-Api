<?php

namespace App\Http\Controllers;
use App\Models\Asset;
use App\Events\AssetCreated;
use Illuminate\Http\Request;
use App\Http\Requests\AssetRequest;
use App\Models\User;
use JWTAuth;

class AssetsController extends Controller
{
    protected $user;

    public function __construct() {

        $this->user = JWTAuth::parseToken()->authenticate();

    }

    public function index() {

        return $this->user->assets()
                          ->get(['type', 'serial_no', 'description', 'fixed_or_movable',
    
                          'picture_path', 'purchase_date', 'start_use_date', 'purchase_price', 'warranty_expiry_date', 'degradation_in_years',
                
                          'current_value', 'location'])
                          ->toArray();
            }
  
     public function store(AssetRequest $request) {

        $validator = $request->validated();
        
        $asset = new Asset();
        $asset->type = $request->type;
        $asset->serial_no = $request->serial_no;
        $asset->description = $request->description;
        $asset->fixed_or_movable = $request->fixed_or_movable;
        $asset->picture_path = $request->picture_path;
        $asset->start_use_date = $request->start_use_date;
        $asset->purchase_price = $request->purchase_price;
        $asset->purchase_date = $request->purchase_date;
        $asset->warranty_expiry_date = $request->warranty_expiry_date;
        $asset->degradation = $request->degradation;
        $asset->current_value = $request->current_value;
        $asset->location = $request->location;
        
         //Invoke Asset Creation Event...
         event(new AssetCreated($asset));

        if ($this->user->assets()->save($asset))   
           return response()->json([
               'success' => true,
               'message' => 'Asset added successfully.',
               'asset' => $asset
           ]);
        else 
            return response()->json([
                'success' => false,
                'message' => 'Sorry, asset could not be added.'
            ]);
            
     }
  
     public function show($id) {

        $asset = $this->user->assets()->find($id);

        if ( !$asset ) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, asset with id ' .$id. ' was not found.'
            ], 400);
        }

        return $asset;
  
     }
  
     public function update(Request $request, $id) {

        $asset = $this->user->assets()->find($id);

        if ( !$asset ) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, asset with id ' .$id. ' was not found.'
            ], 400);
        }

        $updated = $asset->fill($request->all())->save();
                
        if ( $updated ) {

            return response()->json([
                'success' => true,
                'message' => 'Asset updated successfully.'
            ]);

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, asset could not be updated'
            ], 500);
        }
    }
  
     public function destroy() {

        $asset = $this->user->assets()->find($id);

        if ( !$asset ) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, asset with id ' .$id. ' was not found.'
            ], 400);
        }

        if ($asset->delete()) {

            return response()->json([
                'success' => true, 
                'message' => 'Asset deleted successfully'
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, asset could not be deleted'
            ], 500);
        }
    } 
}
