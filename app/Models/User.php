<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Vendor;
use App\Models\Asset;
use App\Models\AssetAssignment;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject {

    use HasFactory, Notifiable;

    protected $fillable = ['first_name', 'middle_name', 'last_name',  'email', 'password', 'phone_no', 

                         'picture_url','is_disabled'];
  
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   
    public function getJWTIdentifier() {

        return $this->getKey();
    }

    
    public function getJWTCustomClaims() {

        return [];
    }   

    public function vendors() {

        return $this->hasMany(Vendor::class);
    }
    
    public function assets() {

        return $this->hasMany(Asset::class);
    }

    public function assets_assignment() {

        return $this->hasMany(AssetAssignment::class);
    }
}
