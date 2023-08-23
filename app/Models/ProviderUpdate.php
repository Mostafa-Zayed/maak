<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderUpdate extends Model
{
    use HasFactory;
    protected $fillable = ['type','phone','country_code','code','code_expire','status','provider_id '];

    /*
     * relationship
     */
    public function provider(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Provider::class,'provider_id','id');
    }

    /*
     * scopes
     */
    public function scopePending($query)
    {
        return $query->where('status','=','pending');
    }
}
