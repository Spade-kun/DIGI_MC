<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDocumentPrivilege extends Model
{
    protected $fillable = [
        'user_id',
        'admin_document_id',
        'can_access',
        'can_add',
        'can_view',
        'can_edit',
    ];

    protected $casts = [
        'can_access' => 'boolean',
        'can_add' => 'boolean',
        'can_view' => 'boolean',
        'can_edit' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(AdminDocument::class, 'admin_document_id');
    }

    public function adminDocument(): BelongsTo
    {
        return $this->belongsTo(AdminDocument::class, 'admin_document_id');
    }
}
