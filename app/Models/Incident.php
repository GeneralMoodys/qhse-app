<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\UserService; // Import UserService

class Incident extends Model
{
    protected $fillable = [
        'reporter_id',
        'incident_type',
        'location',
        'description',
        'category',
        'location_details',
        'latitude',
        'longitude',
        'incident_time',
        'status',
    ];

    protected $casts = [
        'incident_time' => 'datetime',
    ];

    /**
     * Get the user that reported the incident.
     */
    public function getReporterAttribute()
    {
        // Caching sederhana agar tidak query berulang kali
        if (!array_key_exists('reporter_data', $this->attributes)) {
            $this->attributes['reporter_data'] = app(UserService::class)->findById($this->reporter_id);
        }
        return $this->attributes['reporter_data'];
    }

    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }
}