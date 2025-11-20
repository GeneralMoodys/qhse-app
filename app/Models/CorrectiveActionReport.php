<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\UserService; // Important: Import the service

class CorrectiveActionReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'root_cause_analysis_id',
        'number',
        'source_of_information',
        'issued_by',
        'issued_date',
        'status',
        'management_notes',
        'mr_approved_by',
        'mr_approved_at',
        'director_approved_by',
        'director_approved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issued_date' => 'date',
        'mr_approved_at' => 'datetime',
        'director_approved_at' => 'datetime',
    ];

    /**
     * Get the root cause analysis associated with the report.
     */
    public function rootCauseAnalysis(): BelongsTo
    {
        return $this->belongsTo(RootCauseAnalysis::class);
    }

    /**
     * Get the actions associated with the report.
     */
    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }

    /**
     * Get the user who issued the report.
     */
    public function getIssuerAttribute()
    {
        if (!$this->issued_by) {
            return null;
        }
        // Simple caching to avoid repeated queries
        if (!array_key_exists('issuer_data', $this->attributes)) {
            $this->attributes['issuer_data'] = app(UserService::class)->findById($this->issued_by);
        }
        return $this->attributes['issuer_data'];
    }

    /**
     * Get the user who approved as MR.
     */
    public function getMrApproverAttribute()
    {
        if (!$this->mr_approved_by) {
            return null;
        }
        // Simple caching
        if (!array_key_exists('mr_approver_data', $this->attributes)) {
            $this->attributes['mr_approver_data'] = app(UserService::class)->findById($this->mr_approved_by);
        }
        return $this->attributes['mr_approver_data'];
    }

    /**
     * Get the user who approved as Director.
     */
    public function getDirectorApproverAttribute()
    {
        if (!$this->director_approved_by) {
            return null;
        }
        // Simple caching
        if (!array_key_exists('director_approver_data', $this->attributes)) {
            $this->attributes['director_approver_data'] = app(UserService::class)->findById($this->director_approved_by);
        }
        return $this->attributes['director_approver_data'];
    }
}