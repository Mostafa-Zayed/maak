<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Service extends BaseModel
{
    use HasFactory;
    const IMAGEPATH = 'services' ; 

    use HasTranslations; 
    protected $fillable = ['name','slug','status','category_id'];
    public $translatable = ['name'];

    /*
     * relationships
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function request_service(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RequestService::class,'service_id','id');
    }
    public function providers()
    {
//        return $this->belongsToMany()
    }

    /*
     * scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status',1);
    }

    public function scopeNotActive($query)
    {
        return $query->where('status',0);
    }
}
