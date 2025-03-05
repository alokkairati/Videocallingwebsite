<?php

namespace App\Http\Controllers;

use App\Mail\SendInvitation;
use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class MeetingController extends Controller
{
    public function start_meeting(Request $request,$id){
        $userId = $id;
        // Prepare data for the store function
         $request->merge([
             'meeting_link' => url('start-meeting') . '/' . $userId,
             'room_id' => $userId,
             'user_id' => $userId,
         ]);
         // Call the store function
         $this->store($request);
         $userList = User::where('id', '!=', Auth()->user()->id)->orderBy('name', 'asc')->get(); 
         return view('pages.meeting', compact('userId', 'userList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'meeting_link' => 'required|url',
            'room_id' => 'required|string',
            'user_id' => 'required|string',
        ]);
    
        // Check if the meeting link already exists
        $existingMeeting = Meeting::where('room_id', $request->room_id)->first();
        
        if ($existingMeeting) {
            return response()->json(['message' => 'Meeting link already exists!'], 400);
        }

        $endPreviousMeetings = Meeting::where('user_id', Auth()->user()->id)->update(['is_end' => '0']);

        // Create a new meeting if the link is unique
        $meeting = new Meeting();
        $meeting->meeting_link = $request->meeting_link;
        $meeting->room_id = $request->room_id;
        $meeting->meeting_user = $request->user_id;
        $meeting->date = date('Y-m-d');
        $meeting->user_id = Auth()->user()->id;
        $meeting->save();
    
        return response()->json(['message' => 'Meeting saved successfully!'], 200);
    }



    public function joinMeeting(Request $request)
    {
        $checkMeeting = Meeting::where('room_id', $request->room_id)->first();
    
        if ($checkMeeting) {
            $userId = $request->room_id;
            $userList = User::where('id', '!=', Auth()->user()->id)->orderBy('name', 'asc')->get(); 
            return view('pages.meeting', compact('userId', 'userList'));
        }
    }



    public function previousMeeting()
    {
        $meetings = Meeting::where('user_id', auth()->user()->id)
            ->latest()
            ->get()
            ->map(function ($meeting) {
                $meeting->invited_users_counts = $meeting->invitations()->count();
                return $meeting;
            });
        return view('pages.meeting-link', compact('meetings'));
    }
    
    public function saveInvitation(Request $request)
    {
        $request->validate([
            'user_id' => 'required'
        ]);
    
        $getMeeting = Meeting::where('user_id', Auth()->user()->id)->latest()->first();
        if($getMeeting){
            $check = MeetingInvitation::where('room_id',$getMeeting->room_id)->where('invited_user',$request->user_id)->first();
            if(!$check){
                $create = MeetingInvitation::create([
                    'meeting_link' => $getMeeting->meeting_link,
                    'room_id' => $getMeeting->room_id,
                    'user_id' => Auth()->user()->id,
                    'invited_user' => $request->user_id,
                    'date' => date('Y-m-d')
                ]);
                if($create){
                    $this->sendEmail($create->id);
                }
            }
        }
    
        return response()->json(['message' => 'Invitation saved successfully.']);
    }


    public function sendEmail($data)
    {
        $create = MeetingInvitation::where('id',$data)->firstOrFail();
        $user = User::where('id',$create->invited_user)->firstOrFail();

            $name = $user->name ?? 'Dummy Name';
            $meeting_link = $create->meeting_link ?? 'Dummy Link';

        // Send the email using Laravel's Mail facade
        // Mail::to($data['email'])->send(new DetailMail($details));
        Mail::to($user->email)->send(new SendInvitation($name,$meeting_link));
        // Mail::to('hindtechpcryzen@gmail.com')->send(new DetailMail($details));

        return response()->json(['message' => 'Email sent successfully!']);
    }


}
