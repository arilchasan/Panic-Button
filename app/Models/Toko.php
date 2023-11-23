<?php

namespace App\Models;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'toko';
    protected $fillable = [
        'name',
        'address',
        'province_id',
        'regencies_id',
        'district_id',
        'village_id',
        'latitude',
        'longitude',
        'subsription_id',
        'user_id',
        'status',
        'key',
        'status_active'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class , 'province_id');
    }

    public function regencies()
    {
        return $this->belongsTo(Regencies::class);
    }

    public function district()
    {
        return $this->belongsTo(Districts::class);
    }


    public function village()
    {
        return $this->belongsTo(Villages::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class , 'subsription_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
