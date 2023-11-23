<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $fillable = [
        'regency_id',
        'name'
    ];
    public function province()
    {
        return $this->belongsTo(Province::class , );
    }
}
