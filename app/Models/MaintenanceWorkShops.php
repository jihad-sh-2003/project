<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceWorkShops extends Model
{
    use HasFactory;
          protected $fillable = ['name', 'type', 'phone_number','location'];
}
