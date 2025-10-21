<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;

    protected $table = 'posyandu';

    protected $fillable = [
        'puskesmas_id',
        'name',
        'village',
        'district',
        'address',
        'phone',
        'kader_id',
        'is_active',
    ];

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function kader()
    {
        return $this->belongsTo(User::class, 'kader_id');
    }

    public function mothers()
    {
        return $this->hasMany(Mother::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class);
    }
}
