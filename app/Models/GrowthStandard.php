<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrowthStandard extends Model
{
    use HasFactory;

    protected $table = 'growth_standards';

    protected $fillable = [
        'gender',               // male|female
        'indicator',            // wfa|hfa|wfh
        'age_months',           // nullable for wfh
        'length_height_cm',     // nullable for wfh
        'l',
        'm',
        's',
    ];

    protected $casts = [
        'age_months' => 'integer',
        'length_height_cm' => 'float',
        'l' => 'float',
        'm' => 'float',
        's' => 'float',
    ];
}
