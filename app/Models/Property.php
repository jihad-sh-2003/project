<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
   protected $fillable=[
    'user_id',
    'type_id',
    'subtype_id',
    'title',
    'status',
    'description',
    'price',
    'area',
    'floor',
    'rooms_count',
    'latitude',
    'longitude',
    'has_pool',
    'has_garden',
    'has_elevator',
    'solar_energy',
    'features',
        'nearby_services',  
          'approved',
];
   protected $casts = [
            'approved' => 'boolean',
        'has_pool' => 'boolean',
        'has_garden' => 'boolean',
        'has_elevator' => 'boolean',
        'solar_energy' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
      public function type()
    {
        return $this->belongsTo(PropertyType::class , 'type_id');
    }
      public function subtype()
    {
        return $this->belongsTo(PropertySubType::class ,'subtype_id');
    }

        public function images()
{
    return $this->hasMany(PropertyImage::class);
}




    public function favorites()
{
    return $this->hasMany(Favorite::class);
}

    public function ratings()
{
    return $this->hasMany(Rating::class);
}

    public function reports()
{
    return $this->hasMany(Report::class);
}


   public function Documents()
{
    return $this->hasMany(Document::class);
}
}
