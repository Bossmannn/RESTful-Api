<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Events\AssetAssignmentCreated;
use App\Models\AssetAssignment;
use App\Http\Requests\AssetAssignmentRequest;
use JWTAuth;

class AssetsAssignmentController extends Controller {

    protected $user;

    public function __construct(){

        $this->user = JWTAuth::parseToken()->authenticate();

    }

    public function index() {

        return $this->user
                  ->assets_assignment()
                  ->get(['asset_id', 'user_id', 'assignment_date', 

                  'status', 'is_due', 'due_date', 'assigned_by'])
                  ->toArray();
    }

    public function store(AssetAssignmentRequest $request) {

        $validator = $request->validated();

        if(!$validator) {
            return response()->json($validator->errors(), 422);
        }

        $assetassignment =  new AssetAssignment();
        $assetassignment->asset_id = $request->asset_id;
        $assetassignment->assignment_date = $request->assignment_date;
        $assetassignment->status = $request->status;
        $assetassignment->is_due = $request->is_due ? true : false;
        $assetassignment->due_date = $request->due_date;
        $assetassignment->assigned_by = $request->assigned_by;

         //Invoke Assigned Asset Event...
         event(new AssetAssignmentCreated($assetassignment));

        if ($this->user->assets_assignment()->save($assetassignment))
            return response()->json([
                'success' => true,
                'asset' => $assetassignment
        ]);
        else 
            return response()->json([
                'success' => false,
                'message' => 'Sorry, assigned asset could not be added.'
         ]);
    }

    public function show($id) {

        $assetassignment = $this->user->assets_assignment()->find($id);

        if (!$assetassignment) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the assigned asset with id ' .$id. ' was not found.'
            ], 400);
        }

        return $assetassignment;

    }

    public function update(Request $request, $id) {

        $assetassignment = $this->user->assets_assignment()->find($id);

        if (!$assetassignment) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the assigned asset with id ' .$id. ' was not found.'
            ], 400);
        }

        $updated = $assetassignment->fill($request->all())->save();
                
        if ($updated) {

            return response()->json([
                'success' => true,
                'message' => 'Assigned asset updated successfully.',
                'asset assignment' => $assetassignment
            ]);

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, assigned asset could not be updated.'
            ], 500);
        }
    }

    public function destroy($id) {

        $assetassignment = $this->user->assets_assignment()->find($id);

        if (!$assetassignment) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the assigned asset with id ' .$id. ' was not found.'
            ], 400);
        }

        $deleted= $assetassignment->delete();

        if ($deleted) {

            return response()->json([
                'success' => true,
                'message' => 'Assigned asset deleted successfully.'
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the assigned asset could not be deleted.'
            ], 500);
        }
    }   
}
