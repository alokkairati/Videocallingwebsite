<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_link',
        'room_id',
        'meeting_user',
        'user_id',
        'date',
        'is_end',
    ];

 /**
     * Define a relationship with MeetingInvitation.
     */
    public function invitations()
    {
        return $this->hasMany(MeetingInvitation::class, 'meeting_link', 'meeting_link');
    }

    /**
     * Count the total users invited for this meeting by user ID.
     *
     * @param int $userId
     * @return int
     */
    public function countInvitedUsers(int $userId): int
    {
        return $this->invitations()
            ->where('user_id', $userId)
            ->count();
    }



}
