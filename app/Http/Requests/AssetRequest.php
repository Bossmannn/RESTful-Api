<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
{
  
    public function authorize() {

        return true;
        
    }

    
    public function rules() {
        return [
            'type' => 'required',  
            'description' => 'required', 
            'fixed_or_movable' => 'required',  
            'picture_path' => 'required', 
            'purchase_date' => 'required',
            'start_use_date' => 'required', 
            'purchase_price' => 'required', 
            'warranty_expiry_date' => 'required', 
            'degradation' => 'required',
            'current_value' => 'required',
            'location' => 'required'
        ];
    }
}
