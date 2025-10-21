<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'address',
        'district',
        'phone',
        'is_active',
    ];

    public function posyandus()
    {
        return $this->hasMany(Posyandu::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
