<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'category'];
    
    public function users() {

        return $this->belongsTo(User::class);
    }
}
