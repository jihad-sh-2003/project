<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mediator extends Model
{
    use HasFactory;

    
    protected $fillable = ['name','contact_info','location'];

    public function appointments()
    {
        return $this->hasMany(MediatorAppointment::class);
    }
}
