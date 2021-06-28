<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AssetAssignment;
use App\Models\User;

class Asset extends Model {

    use HasFactory;

    protected $table = 'assets';

    protected $fillable = ['user_id', 'type', 'serial_no', 'description', 'fixed_or_movable',
    
    'picture_path', 'purchase_date', 'start_use_date', 'purchase_price', 'warranty_expiry_date', 'degradation',

    'current_value', 'location'

     ];

     public function users() {

        return $this->belongsTo(User::class);

     }

     public function assets_management() {

        return $this->hasMany(AssetAssignment::class);
        
     }
}
