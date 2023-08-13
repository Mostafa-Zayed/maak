<?php

namespace App\Models;


class Coupon extends BaseModel
{
    protected $fillable = ['coupon_num','type','discount','max_discount','expire_date','max_use','use_times','status'];
}
