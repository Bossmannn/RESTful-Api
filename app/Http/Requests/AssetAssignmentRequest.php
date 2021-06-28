<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetAssignmentRequest extends FormRequest
{
    
    public function authorize() {

        return true;

    }

    
    public function rules() {
        return [ 
            'assignment_date' => 'required',  
            'status' => 'required',  
            'due_date' => 'required', 
            'assigned_by' => 'required'
        ];
    }
}
