<?php

use App\Models\Meeting;
use App\Models\MeetingInvitation;

if (!function_exists('is_invited')) {
    function is_invited($invitedId,$room_id) {
        $check = MeetingInvitation::where('room_id',$room_id)->where('invited_user',$invitedId)->first();
        if($check){
            return true;
        }
        return false;
    }
}


if (!function_exists('is_meeting_owner')) {
    function is_meeting_owner() {
        $getMeeting = Meeting::where('user_id', Auth()->user()->id)->latest()->first();
        if($getMeeting){
            return true;
        }
        return false;
    }
}