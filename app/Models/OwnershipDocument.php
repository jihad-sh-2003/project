<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnershipDocument extends Model
{
    use HasFactory;

    
    protected $fillable = ['document_type', 'document_url', 'upload_at', 'reservation_id'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

}
