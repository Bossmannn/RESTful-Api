<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Asset;
use App\Models\User;

class AssetAssignment extends Model
{
    use HasFactory;

    protected $table = 'assets_management';

    protected $fillable = ['asset_id', 'user_id', 'assignment_date', 

     'status', 'is_due', 'due_date', 'assigned_by'

    ];

    public function users() {

        return $this->belongsTo(User::class);
    }

    public function assets(){

        return $this->belongsTo(Asset::class);
    }
}
