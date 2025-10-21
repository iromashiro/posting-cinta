<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Measurement extends Model
{
    use HasFactory;

    protected $table = 'measurements';

    protected $fillable = [
        'child_id',
        'measured_at',
        'weight',
        'height',
        'head_circumference',
        'age_months',
        'weight_for_age_z',
        'height_for_age_z',
        'weight_for_height_z',
        'nutrition_status',
        'notes',
        'created_by',
        'synced_at',
    ];

    protected $casts = [
        'measured_at' => 'date',
        'synced_at' => 'datetime',
        'weight' => 'float',
        'height' => 'float',
        'head_circumference' => 'float',
        'weight_for_age_z' => 'float',
        'height_for_age_z' => 'float',
        'weight_for_height_z' => 'float',
    ];

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
