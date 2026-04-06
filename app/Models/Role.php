<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['name', 'display_name'];

    /**
     * Get all users with this role
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if role is admin
     */
    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }

    /**
     * Check if role is panitia
     */
    public function isPanitia(): bool
    {
        return $this->name === 'panitia';
    }

    /**
     * Check if role is ustad
     */
    public function isUstad(): bool
    {
        return $this->name === 'ustad';
    }

    /**
     * Check if role is santri
     */
    public function isSantri(): bool
    {
        return $this->name === 'santri';
    }
}
