<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\UserService; // Import UserService

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'auditor_id',
        'schedule_date',
        'status',
        'audit_template_id',
    ];

    protected $casts = [
        'schedule_date' => 'datetime',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(AuditTemplate::class);
    }

    public function getAuditorAttribute()
    {
        // Caching sederhana agar tidak query berulang kali
        if (!array_key_exists('auditor_data', $this->attributes)) {
            $this->attributes['auditor_data'] = app(UserService::class)->findById($this->auditor_id);
        }
        return $this->attributes['auditor_data'];
    }

    public function items(): HasMany
    {
        return $this->hasMany(AuditItem::class);
    }
}