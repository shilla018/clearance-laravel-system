<?php

namespace App\Policies;

use App\Models\SystemNotification;
use App\Models\User;

class SystemNotificationPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SystemNotification $notification): bool
    {
        // Only the recipient can view their own notification
        return $user->id === $notification->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SystemNotification $notification): bool
    {
        // Only the recipient can mark as read/update
        return $user->id === $notification->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SystemNotification $notification): bool
    {
        // Only the recipient can delete their notification
        return $user->id === $notification->user_id;
    }

    /**
     * Determine whether the user can view any notifications.
     */
    public function viewAny(User $user): bool
    {
        // All users can view their own notifications
        return true;
    }
}
