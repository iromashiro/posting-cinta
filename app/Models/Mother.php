<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mother extends Model
{
    use HasFactory;

    protected $table = 'mothers';

    protected $fillable = [
        'posyandu_id',
        'name',
        'nik',
        'address',
        'phone',
        'created_by',
    ];

    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(Posyandu::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Child::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
