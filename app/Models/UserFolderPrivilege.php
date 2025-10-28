<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFolderPrivilege extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'folder_id',
        'folder_name',
        'can_access',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'can_access' => 'boolean',
    ];

    /**
     * Get the user that owns the privilege.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
