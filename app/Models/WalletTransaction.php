<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

        protected $fillable = ['amount', 'method', 'reference_number', 'approved', 'wallet_id'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

}
