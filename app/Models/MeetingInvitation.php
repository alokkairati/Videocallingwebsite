<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_link',
        'room_id',
        'user_id',
        'invited_user',
        'date',
        'is_joined',
    ];

    public static function countInvitedUsers(string $meetingLink, int $userId): int
    {
        return self::where('meeting_link', $meetingLink)
            ->where('user_id', $userId)
            ->count();
    }

}
