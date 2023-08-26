<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Department extends Model
{
    use HasFactory;

    const IMAGEPATH = 'departments' ;

    use HasTranslations;
    protected $fillable = ['name','slug','status'];
    public $translatable = ['name'];
    /*
     * scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status',1);
    }
}
