<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertySubType extends Model
{
    use HasFactory;

    protected $fillable = ['subtype', 'type_id'];



    public function properties()
{
    return $this->hasMany(Property::class);
}
   public function type()
    {
        return $this->belongsTo(PropertyType::class , 'type_id');
    }
    
}
