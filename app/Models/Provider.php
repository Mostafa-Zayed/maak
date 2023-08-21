<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Provider extends Authenticatable
{
    use HasFactory;


    protected $fillable = ['name','image','phone','country_code','email','password','description','bank_account','bank_account','lng','map_desc','code','code_expire',
                            'level_experience','active','is_notify','is_approved','is_blocked','created_at','updated_at','deleted_at'];



}
