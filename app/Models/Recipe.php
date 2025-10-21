<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'age_category', // mpasi_6_12|balita_1_3|anak_3_5
        'image_path',
        'ingredients',
        'instructions',
        'nutrition_info',
        'calories',
        'protein',
        'carbohydrate',
        'created_by',
        'is_published',
    ];

    protected $casts = [
        'nutrition_info' => 'array',
        'is_published' => 'boolean',
        'calories' => 'integer',
        'protein' => 'integer',
        'carbohydrate' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
