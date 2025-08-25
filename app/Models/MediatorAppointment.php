<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediatorAppointment extends Model
{
    use HasFactory;

    
    protected $fillable = ['mediator_id','user_id','property_id','status','date','time'];

    public function mediator()
    {
        return $this->belongsTo(Mediator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
