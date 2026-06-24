<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assigned_to',
        'subject',
        'message',
        'status',
        'priority',
        'admin_feedback',
        'responded_at',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
