<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\UserService; // Import UserService

class Document extends Model
{
    protected $fillable = [
        'title',
        'document_type',
        'file_path',
        'expiry_date',
        'version',
        'uploaded_by',
    ];

    public function getUploadedByAttribute()
    {
        // Caching sederhana agar tidak query berulang kali
        if (!array_key_exists('uploaded_by_data', $this->attributes)) {
            $this->attributes['uploaded_by_data'] = app(UserService::class)->findById($this->uploaded_by);
        }
        return $this->attributes['uploaded_by_data'];
    }
}