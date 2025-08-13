<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'role',
        'is_active',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
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
     * Check if user is a manager
     * 
     * @return bool
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Check if user is a pharmacist
     * 
     * @return bool
     */
    public function isPharmacist(): bool
    {
        return $this->role === 'pharmacist';
    }

    /**
     * Check if user has permission to manage staff
     * 
     * @return bool
     */
    public function canManageStaff(): bool
    {
        return $this->isManager();
    }

    /**
     * Check if user has permission to manage inventory
     */
    public function canManageInventory(): bool
    {
        return $this->isManager();
    }

    /**
     * Check if user has permission to view analytics
     */
    public function canViewAnalytics(): bool
    {
        return $this->isManager();
    }

    /**
     * Check if user has permission to generate reports
     */
    public function canGenerateReports(): bool
    {
        return $this->isManager();
    }

    /**
     * Check if user has permission to process sales
     */
    public function canProcessSales(): bool
    {
        return $this->is_active;
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Get user's role display name
     */
    public function getRoleDisplayNameAttribute(): string
    {
        return ucfirst($this->role);
    }

    /**
     * Get user's status display name
     */
    public function getStatusDisplayNameAttribute(): string
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }
}
