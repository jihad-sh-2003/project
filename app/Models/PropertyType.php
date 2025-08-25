<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use HasFactory;
    protected $fillable = ['type'];




  public function subtypes()
    {
        return $this->hasMany(PropertySubType::class, 'subtype_id');
    }
public function properties()
{
    return $this->hasMany(Property::class);
}}


