<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the folder privileges for the user.
     */
    public function folderPrivileges(): HasMany
    {
        return $this->hasMany(UserFolderPrivilege::class);
    }

    /**
     * Check if user has access to a specific folder.
     */
    public function hasAccessToFolder(string $folderId): bool
    {
        $privilege = $this->folderPrivileges()
            ->where('folder_id', $folderId)
            ->first();

        // If no privilege exists, deny access by default
        if (!$privilege) {
            return false;
        }

        return $privilege->can_access;
    }
}
