<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    
    protected $fillable = ['amount', 'status', 'payment_method', 'payment_reference', 'date', 'reservation_id', 'bank_id'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
