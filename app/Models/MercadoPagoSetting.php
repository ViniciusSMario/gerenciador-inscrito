<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MercadoPagoSetting extends Model
{
    protected $fillable = [
        'access_token',
        'sandbox',
    ];
}
