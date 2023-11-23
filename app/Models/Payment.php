<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = "payment_history";
    protected $fillable = [
        'code_bill',
        'package_fee',
        'installation_fee',
        'admin_fee',
        'transaction_time',
        'payment_time',
        'status',
        'user_id',
        'subscription_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class , 'subscription_id');
    }
}
