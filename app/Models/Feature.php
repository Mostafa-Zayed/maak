<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Feature extends BaseModel
{
    use HasFactory;
    const IMAGEPATH = 'features' ; 

    use HasTranslations; 
    protected $fillable = ['name','status'];
    public $translatable = ['name'];

}
