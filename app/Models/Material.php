<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'unit_price',
        'description',
    ];
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
