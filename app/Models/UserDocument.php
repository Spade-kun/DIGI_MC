<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDocument extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'file_path',
        'file_name',
        'status',
        'rejection_reason',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the document
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who reviewed the document
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    /**
     * Scope to get pending documents
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get approved documents
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to get rejected documents
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Get available categories
     */
    public static function getCategories(): array
    {
        return [
            'City Legal Office',
            'Executive and Administrative Issuances',
            'Office Orders and Official Communications',
            'Render Written Opinion',
            'Legal Consultancy / Assistance',
            'Limited Legal Services',
            'Sworn Statements/ Affidavits',
            'Notarial Services',
            'Deeds, Contracts and MOA',
        ];
    }
}
