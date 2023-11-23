<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscription';
    protected $fillable = [
        'subscription_name',
        'price_installation',
        'maintenance_price',
        'day',
    ];

    public function toko()
    {
        return $this->hasMany(Toko::class);
    }
}
