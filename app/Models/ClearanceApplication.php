<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearanceApplication extends Model
{
    use HasFactory;

    public const DEPARTMENTS = [
        'finance' => 'Finance Office',
        'library' => 'Library',
        'academic' => 'Academic Department',
        'accommodation' => 'Accommodation',
    ];

    protected $fillable = [
        'user_id',
        'reason',
        'mobile_number',
        'academic_year',
        'status',
        'applied_at',
        'completed_at',
        'due_at',
        'metadata',
        'resubmission_allowed',
        'resubmission_count',
        'resubmitted_at',
        'denial_reason',
        'parent_application_id',
    ];

    protected function casts(): array
    {
        return [
            'applied_at' => 'datetime',
            'completed_at' => 'datetime',
            'due_at' => 'datetime',
            'resubmitted_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(ClearanceReview::class);
    }

    public function parentApplication()
    {
        return $this->belongsTo(ClearanceApplication::class, 'parent_application_id');
    }

    public function resubmissions()
    {
        return $this->hasMany(ClearanceApplication::class, 'parent_application_id');
    }

    public function canResubmit(): bool
    {
        return $this->status === 'denied' && $this->resubmission_allowed;
    }

    public function markForResubmission(string $reason = null): void
    {
        $this->update([
            'resubmission_allowed' => true,
            'denial_reason' => $reason,
        ]);
    }

    public function refreshStatusFromReviews(): void
    {
        $reviews = $this->reviews()->get();

        if ($reviews->contains('status', 'denied')) {
            $deniedReview = $reviews->firstWhere('status', 'denied');

            $this->forceFill([
                'status' => 'denied',
                'completed_at' => $this->completed_at ?? now(),
                'resubmission_allowed' => true,
                'denial_reason' => $deniedReview?->comments,
            ])->save();
            return;
        }

        if ($reviews->count() >= count(self::DEPARTMENTS) && $reviews->every(fn ($review) => $review->status === 'approved')) {
            $this->forceFill([
                'status' => 'approved',
                'completed_at' => $this->completed_at ?? now(),
                'resubmission_allowed' => false,
            ])->save();
            return;
        }

        $this->forceFill([
            'status' => 'pending',
            'completed_at' => null,
            'resubmission_allowed' => false,
        ])->save();
    }
}
