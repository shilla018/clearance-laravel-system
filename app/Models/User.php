<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const DEPARTMENTS = [
        'finance' => 'Finance Office',
        'library' => 'Library',
        'academic' => 'Academic Department',
        'accommodation' => 'Accommodation',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'full_name',
        'email',
        'registration_number',
        'role',
        'phone',
        'sex',
        'programme',
        'department',
        'level',
        'campus',
        'academic_year',
        'department_key',
        'password_expires_at',
        'email_verified_at',
        'password',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'password_expires_at' => 'datetime',
        ];
    }

    public function clearanceApplications()
    {
        return $this->hasMany(ClearanceApplication::class);
    }

    public function latestClearanceApplication()
    {
        return $this->hasOne(ClearanceApplication::class)->latestOfMany();
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function systemNotifications()
    {
        return $this->hasMany(SystemNotification::class);
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'clearance_admin', 'hgadmin'], true);
    }

    public function isOfficer(): bool
    {
        return $this->role === 'officer';
    }
}
