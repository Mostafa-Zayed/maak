<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Country extends BaseModel
{
    use HasTranslations; 
    
    protected $fillable = ['name','key'];
    
    public $translatable = ['name'];

    public function regions()
    {
        return $this->hasMany(Region::class, 'country_id', 'id');
    }
}
