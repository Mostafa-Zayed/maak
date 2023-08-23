<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use const http\Client\Curl\PROXY_HTTP;

class Provider extends Authenticatable
{
    use HasFactory,HasApiTokens;
    protected $fillable = ['name','image','phone','country_code','email','password','description','bank_account','bank_name','bank_username','bank_iban','lng','map_desc','code','code_expire',
                            'level_experience','active','is_notify','is_approved','is_blocked','created_at','updated_at','deleted_at','category_id'];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function logout()
    {
        $this->tokens()->delete();
        // $this->currentAccessToken()->delete();
        if (request()->device_id) {
            $this->devices()->where(['device_id' => request()->device_id])->delete();
        }
        return true;
    }

    /*
     * relationships
     */
    public function devices(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Device::class, 'morph');
    }

    public function updates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return   $this->hasMany(ProviderUpdate::class,'provider_id','id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    // setters
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

}
