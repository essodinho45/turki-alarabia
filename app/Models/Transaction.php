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
        'branch_id',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public static function boot(): void
    {
        parent::boot();
        static::creating( function (Transaction $transaction){
            $transaction->user_id = auth()->user()->id ?? 1;
            $transaction->branch_id = auth()->user()->branch_id ?? 1;
        });
    }

}
