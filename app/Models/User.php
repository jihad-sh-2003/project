<?php

namespace App\Models;

use App\Http\Responses\Response;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'otp',
        'otp_expiry',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
       'password',
    'remember_token',
    'otp',
    'otp_expiry',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function GenerateOtp() 
     {
        $this->otp = random_int(1000, 9999);
        $this->otp_expiry=Carbon::now()->addMinutes(15);
        $this->save();
        return $this->otp;
       
    }
    public function properties()
    {

       return $this->hasMany(Property::class);
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
    return $this->hasMany(Rating::class);
}

public function wallet()
{
    return $this->hasOne(Wallet::class);
}


}
