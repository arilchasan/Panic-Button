<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $table = 'province';
    protected $fillable = [
        'name'
    ];

    public function toko()
    {
        return $this->hasMany(Toko::class);
    }

    public function regencies()
    {
        return $this->hasMany(Regencies::class  );
    }
}
