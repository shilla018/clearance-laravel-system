<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearanceReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'clearance_application_id',
        'department_key',
        'department_name',
        'status',
        'comments',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function application()
    {
        return $this->belongsTo(ClearanceApplication::class, 'clearance_application_id');
    }

    public function clearanceApplication()
    {
        return $this->belongsTo(ClearanceApplication::class, 'clearance_application_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
