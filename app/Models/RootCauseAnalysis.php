<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RootCauseAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'accident_id',
        'analysis_method',
        'analysis_data',
        'root_cause_summary',
        'root_cause_category',
        'is_human_factor',
        'is_equipment_factor',
        'is_material_factor',
        'is_method_factor',
        'is_environment_factor',
    ];

    protected $casts = [
        'analysis_data' => 'array',
        'is_human_factor' => 'boolean',
        'is_equipment_factor' => 'boolean',
        'is_material_factor' => 'boolean',
        'is_method_factor' => 'boolean',
        'is_environment_factor' => 'boolean',
    ];

    public function accident(): BelongsTo
    {
        return $this->belongsTo(Accident::class);
    }

    public function car(): HasOne
    {
        return $this->hasOne(CorrectiveActionReport::class);
    }
}
