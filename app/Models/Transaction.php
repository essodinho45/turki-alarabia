<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'amount',
        'material_id',
        'quantity',
        'client_name',
        'client_national_id',
        'client_phone',
        'user_id',
    ];

}
